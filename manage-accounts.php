<?php
session_start();

if(!isset($_SESSION["USERNAME"]))
{
    header('Location: user-login.php');
}
?>
<?php ?>
<?php
define("PAGE_TITLE", "Manage Accounts - Air Quality Monitoring System");

?>
<?php include('include/admin-header.php'); ?>
<style>
    select[name="example_length"] {
        width: 100px;
        display: inline;
    }

    input[type=search] {
        width: 150px;
    }

    .centered-nav {
        left: -37%;
    }
</style>

<main>
    <div class='container'>
        <br>

        <div class="section no-pad-bot">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">
                        <b>Manage Accounts</b>
                    </div>
                    <a class="waves-effect waves-light btn modal-trigger" href="#addAcc"><i class="material-icons left">account_circle</i>ADD NEW</a>

                    <div id="addAcc" class="modal">
                        <div class="modal-content">
                            <h4>Add New Account</h4>
                            <?php include('add-account.php');?>
                            <form method = "post" action="">
                                <div class="row">
                                    <div class='input-field col s12'>
                                        <input id='username' name='username' type='text' class='validate' required>
                                        <label>Username</label>
                                    </div>
                                    <div class='input-field col s12'>
                                        <input id='username' name='password' type='password' class='validate' required>
                                        <label>Password</label>
                                    </div>
                                    <div class="col s12">
                                        <select name = "privilege" id = "privilege" required>
                                            <option value="" disabled selected>Select a privilege</option>
                                            <option value="0">SUPER ADMIN</option>
                                            <option value="1">USER</option>

                                            <option value="2">DISABLED</option>
                                        </select>
                                    </div>
                                    <div class="red-text">
                                        <?php echo $error ?>
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button class='waves-effect waves-green btn-flat' name="submit" type="submit">Submit</button>
                            <a href="#" class=" modal-action modal-close waves-effect waves-green btn-flat">CLOSE</a>
                        </div>
                        </form>
                    </div>

                    <br>
                    <br>
                    <table id='example' class='highlight' width='100%'>
                        <thead>
                        <tr>
                            <th data-field='time'>UID</th>
                            <th data-field='area'>USERNAME</th>
                            <th data-field='pollutant'>PRIVILEGE</th>
                            <th data-field='pollutant'>DATE CREATED</th>
                            <th data-field='symbol'>CREATED BY</th>
                            <th data-field='function'></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include('include/db_connect.php');

                        function returnPrivilege($privilege){
                            if($privilege == "0"){
                                return "SUPER ADMIN";
                            }else if($privilege == "1"){
                                return "USER";
                            }else{
                                return "DISABLED";
                            }
                        }

                        $query = "SELECT * FROM ACCOUNT ORDER BY DATE_CREATED DESC";
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            if (mysqli_num_rows($result) == 0) {
                                echo "NO DATA";
                            } else {
                                $ctr = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $identifier = "ROW_" . $ctr;
                                    $identifier_input1 = "E_ROW_A" . $ctr;
                                    $identifier_input2 = "E_ROW_B" . $ctr;
                                    $identifier_input3 = "E_ROW_C" . $ctr;

                                    echo "<tr>";
                                    echo "<td>" . $row['UID'] . "</td>";
                                    echo "<td>" . $row['USERNAME'] . "</td>";
                                    echo "<td>" . returnPrivilege($row['PRIVILEGE']) . "</td>";
                                    echo "<td>" . $row['DATE_CREATED'] . "</td>";
                                    echo "<td>" . $row['CREATED_BY'] . "</td>";
                                    echo "<td><a data-target='" . $identifier . "' class='waves-effect waves-light btn modal-trigger'>Edit</a></td>";
                                    echo "</tr>";

                                    $userid = $row['UID'];
                                    $username = $row['USERNAME'];

                                    echo "
                        <div id='" . $identifier . "' class='modal'>
                          <div class='modal-content' style='padding: 24px 24px 0px 24px;'>
                              <div class='row-no-after'>
                                <div class='col s12'>
                                   <div class='row'>
                                      <div class='col s12'>
                                          <h4>Manage Account</h4>
                                          <div class='divider'></div>
                                      </div>
                                   </div>
                                   
                                   <div class='row'>
                                      <div class='col s3'>
                                          <label class='teal-text emphasize-text'>Username :</label>
                                      </div>
                                      <div class='col s7'>
                                          <span>" . $username . "</span>
                                      </div>
                                  </div>
                                  
                                  <div class='row' style='margin-bottom: 0px;'>
                                    <div class='input-field col s12'>
                                        <input id='$identifier_input2' name='password' type='password'>
                                        <label>Password</label>
                                    </div>
                                  </div>
                                  
                                  <div class='input-field col s12'>
                                    <select name = 'drpPrivilege' id = '$identifier_input3' required>
                                    ";
                                    if($row['PRIVILEGE'] == "0"){
                                        echo "
                                                <option value='' disabled>Select account privilege</option>
                                                <option value='1' selected>SUPER ADMIN</option>
                                                <option value='2'>USER</option>
                                                <option value='3'>DISABLED</option>
                                            ";
                                    }else if($row['PRIVILEGE'] == "1"){
                                        echo "
                                                <option value='' disabled>Select account privilege</option>
                                                <option value='1'>SUPER ADMIN</option>
                                                <option value='2' selected>USER</option>
                                                <option value='3'>DISABLED</option>
                                            ";
                                    }else{
                                        echo "
                                                <option value='' disabled>Select account privilege</option>
                                                <option value='1'>SUPER ADMIN</option>
                                                <option value='2'>USER</option>
                                                <option value='3' selected>DISABLED</option>
                                            ";
                                    }
                                    echo "
                                    </select>
                                    <label>Privilege</label>
                                </div>
                              </div>
                          </div>
                        </div>
                        ";

                                    $userid = json_encode($row['UID']);
                                    $username = json_encode($row['USERNAME']);

                                    echo "
                        <div class='modal-footer'>
                            <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cancel</a>
                            <button id='btnSave' onclick='saveAccount($userid, $username, $identifier_input2, $identifier_input3)' class='modal-action waves-effect waves-green btn-flat'>Save</button>
                        </div>
                        ";

                                    $ctr++;
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</main>
<?php include('include/footer.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
<script type='text/javascript' charset='utf8' src='//cdn.datatables.net/1.10.12/js/jquery.dataTables.js'></script>
<script src="js/manage-accounts.js"></script>
</html>