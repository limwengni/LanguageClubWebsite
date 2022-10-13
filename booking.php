<!DOCTYPE html>
<!--booking-->
<html>
    <head>

        <meta charset="UTF-8">
        <title>Booking Event</title>
        <link rel="stylesheet" href="booking.css">
    </head>

    <body>
        <?php
        include 'header.php';
        include 'helper.php';
        error_reporting(E_ALL ^ E_NOTICE);
        ?>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['AdminEmail'])) {
            include 'logout.php';
            header("Location: login.php");
        } else if (isset($_SESSION['MemberEmail'])) {
            
        } else {
            header("Location: login.php");
        }
        ?>
        <h1 style="text-align: center; margin-top: 50px;">Booking Details</h1>

        <div >
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $LanguageClass = trim($_POST['LanguageClass']);
                $Bank = trim($_POST['Bank']);
                $CardNumber = trim($_POST['CardNumber']);
                $CardExpiry = trim($_POST['CardExpiry']);
                $CVV = trim($_POST['CVV']);
                $email = $_SESSION['MemberEmail'];

                $expirypattern = "/\d\d\\\d\d/";

                if (empty($Bank)) {
                    $error['Bank'] = 'Please select a <b>Bank</b>';
                }
                $length = strlen((string) $CardNumber);
                if ($length != 19) { //include the 3 spaces
                    $error['CardNumber'] = 'Please enter <b>16 digit card number</b>';
                }

                if (preg_match($expirypattern, $CardExpiry)) {
                    $error['CardExpiry'] = 'Please Enter valid <b>Card Expiry</b>';
                }
                if (empty($CVV)) {
                    $error['CVV'] = 'Please select a <b>CVV</b>';
                }
                if (!empty($error)) {
                    echo '<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
                    foreach ($error as $e => $t) {
                        echo "<li>$t</li>";
                    }
                    echo '</ul></div>';
                } else {
                    $sql = "UPDATE member SET LanguageClass='$LanguageClass' WHERE MemberEmail='$email'";
                    $result = $conn->query($sql);

                    $sql1 = "INSERT INTO payment (Bank, CardNumber, CardExpiry, CVV) VALUES (?,?,?,?)";
                    $stmt = $conn->prepare($sql1);
                    $stmt->bind_param('sssi', $Bank, $CardNumber, $CardExpiry, $CVV);
                    $stmt->execute();

                    if ($stmt) {
                        $sql2 = "create or replace view eventstat as select a.*, count(b.Event_ID) as SeatReav, a.MaxPersons-count(b.Event_ID) as SeatsAvail from event a left join booking b on a.Event_ID = b.Event_ID group by a.Event_ID";
                        $result2 = $conn->query($sql2);

                        $sql3 = "create or replace view event_participant_based_on_gender as
with gender as (
    select 
        MemberID, 
        case when MemberGender like 'F' then 1 else 0 end as female,
        case when MemberGender like 'F' then 0 else 1 end as male
    from member
)
select
    e.Event_ID              as Event_ID,
    e.Event_Name            as Event_Name,
    sum(female) + sum(male) as Total_Member, 
    sum(female)             as Num_Female,
    sum(male)               as Num_Male
from 
    member m
    join event  e on m.LanguageClass = e.Language_Name
    join gender g on m.MemberID = g.MemberID
group by e.Event_ID;";
                        $result3 = $conn->query($sql3);
                    }

                    if ($result3) {
                        echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Joined Successfully!</h4></div>';

//                        echo "Member <strong>$id</strong> has been updated.</div>";
                    } else {
                        echo '<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
                        echo "<li>Record Update Error.</li>";
                        echo '</ul></div>';
                    }
                }
            }

            $sql = "SELECT * FROM member WHERE memberEmail = '$email'  ";
            $result = $conn->query($sql);
            $c0 = 'MemberID';
            $c1 = 'MemberName';
            $c2 = 'MemberIC';
            $c3 = 'MemberEmail';
            $c4 = 'MemberMobile';
            $c5 = 'LanguageClass';
            $paymentMethod = 'paymentMethod';

            $self = $_SERVER['PHP_SELF'];

            $c5 = $_GET['LanguageClass'];
            if ($result->num_rows > 0) {


                while ($col = $result->fetch_assoc()) {
                    $id = $col[$c0];
                    $name = $col[$c1];
                    $ic = $col[$c2];
                    $email = $col[$c3];
                    $phone = $col[$c4];
                    $LanguageClass = $c5;
                }
            }
            ?>

            <div class = "bookingForm">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
                    <table class ="table table-hover" style="border-collapse: collapse;">
                        <tr>
                            <th class="head">ID</th>
                            <td class="head"><?= $id ?>
                                <input type='hidden' name="id" 
                                       value="<?= $id ?>"></td>
                        </tr>
                        <tr>
                            <th class="head">Name</th>
                            <td class="head"><?= $name ?>
                                <input type="hidden" name="name" 
                                       <?= $name ?>>
                            </td>
                        </tr>   
                        <tr>
                            <th class="head">IC</th>
                            <td class="head"><?= $ic ?>
                                <input type="hidden" name="ic" 
                                       <?= $ic ?>>
                            </td>
                        </tr>
                        <tr>
                            <th class="head">Email</th>
                            <td class="head"><?= $email ?>
                                <input type="hidden" name="email" 
                                       <?= $email ?>>
                            </td>
                        </tr>
                        <tr>
                            <th class="head">Mobile Phone</th>
                            <td class="head"><?= $phone ?>
                                <input type="hidden" name="phone" id="phone" >

                            </td>
                        </tr>
                        <tr>
                            <th class="head">Language Class</th>
                            <td class="head"><?= $LanguageClass ?>
                                <input type="hidden" name="LanguageClass" 
                                       value = <?= $LanguageClass ?>>
                            </td>

                    </table> 

                    <div class="payment">
                        <h3 class="mt-0 mb-4 text-center" style="padding-bottom: 30px;margin: 10px;font-size: 2.5em">Enter your card details to pay</h3>

                        <table class="table table-hover">
                            <div>
                                <tr>
                                    <th>Payment Method :</th>
                                    <td><select name="Bank" class="form-select">
                                            <option value="">-- Select One --</option>
                                            <?php
                                            foreach (getBankList() as $v => $t) {
                                                echo "<option value=$v>$t</option>";
                                            }
                                            ?></td>
                                </tr>
                            </div> 

                            <div class="row">
                                <tr>
                                    <th>Card Number :</th>
                                    <td>
                                        <input type="text" name="CardNumber" class="form-control" required <?php echo isset($CardNumber) ? "value=$CardNumber" : null ?>>
                                    </td>
                                </tr>
                            </div>

                            <div class="row">
                                <tr>
                                    <th>Card Expiry(my) :</th>
                                    <td>
                                        <input type="text" name="CardExpiry" class="form-control" required <?php echo isset($CardExpiry) ? "value=$CardExpiry" : null ?>>
                                    </td>
                                </tr>
                            </div>

                            <div class="col-6" style="padding-top:30px">
                                <tr>
                                    <th>CVV :</th>
                                    <td>
                                        <input type="text" name="CVV" class="form-control" required <?php echo isset($CVV) ? "value=$CVV" : null ?>>
                                    </td>
                                </tr>    
                            </div>
                    </div>
                    </table>
                    <input type="submit" value="Insert" class="btn btn-primary">
                    <a href="menu.php" class="btn btn-outline-secondary">Cancel</a> 
                </form>
            </div>
        </div>




    </div>            
    <script>
        function upperCase() {
            var x = document.getElementById("name");
            x.value = x.value.toUpperCase();
        }

        var x, i, j, l, ll, selElmnt, a, b, c;
        /*look for any elements with the class "custom-select":*/
        x = document.getElementsByClassName("custom-select");
        l = x.length;
        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;
            /*for each element, create a new DIV that will act as the selected item:*/
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);
            /*for each element, create a new DIV that will contain the option list:*/
            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");
            for (j = 1; j < ll; j++) {
                /*for each option in the original select element,
                 create a new DIV that will act as an option item:*/
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;
                c.addEventListener("click", function (e) {
                    /*when an item is clicked, update the original select box,
                     and the selected item:*/
                    var y, i, k, s, h, sl, yl;
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sl = s.length;
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < sl; i++) {
                        if (s.options[i].innerHTML == this.innerHTML) {
                            s.selectedIndex = i;
                            h.innerHTML = this.innerHTML;
                            y = this.parentNode.getElementsByClassName("same-as-selected");
                            yl = y.length;
                            for (k = 0; k < yl; k++) {
                                y[k].removeAttribute("class");
                            }
                            this.setAttribute("class", "same-as-selected");
                            break;
                        }
                    }
                    h.click();
                });
                b.appendChild(c);
            }
            x[i].appendChild(b);
            a.addEventListener("click", function (e) {
                /*when the select box is clicked, close any other select boxes,
                 and open/close the current select box:*/
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }
        function closeAllSelect(elmnt) {
            /*a function that will close all select boxes in the document,
             except the current select box:*/
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;
            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }
        /*if the user clicks anywhere outside the select box,
         then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);
    </script>

</body>
<?php include 'footer.php'; ?>
</html>
