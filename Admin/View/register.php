
<?php 
include('session.php');
include "../DB Operations/dbconnection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Business Management System </title>

    <!-- Custom fonts for this template-->
    <!-- <link href="/css/acecss.css" rel="stylesheet" type="text/css"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <!-- <link href="css/acecss.css" rel="stylesheet"> -->

    <!-- <link rel="stylesheet" type="text/css" href="vendor/parsley/parsley.css" /> -->
    <style>
    .bg-gradient-primary {
        background-color: #4e73df;
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        background-size: cover;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
    }

    .mt-5,
    .my-5 {
        margin-top: 3rem !important;
    }

    .p-5 {
        padding: 3rem !important;
    }

    .mb-4,
    .my-4 {
        margin-bottom: 1.5rem !important;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -.75rem;
        margin-left: -.75rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    .text-center {
        text-align: center !important;
    }

    .text-gray-900 {
        color: #3a3b45 !important;
    }

    label {
        display: inline-block;
        margin-bottom: .5rem;
    }

    body {
        margin: 0;
        font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #858796;
        text-align: left;
        background-color: #fff;
    }
    </style>
</head>
<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-9 col-lg-9 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <form method="post" action="../Controller/newcompany.php" >
                      
                            <div class="p-5">
                                <span id="message"></span>
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Set up your Business Account</h1>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Business Name</label>
                                            <input type="text" name="companyname" id="companyname"
                                                class="form-control" required data-parsley-maxlength="175"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Business Address</label>
                                            <input type="text" name="companyaddress" id="companyaddress"
                                                class="form-control" required data-parsley-maxlength="250"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Business Contact No.</label>
                                            <input type="text" name="companycontact" id="companycontact"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Business Tag Line</label>
                                            <input type="text" name="companytag" id="companytag"
                                                class="form-control" required data-parsley-maxlength="200"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>

                                   

                                    <!-- <div id="branch" class="col-md-6" style="display: none">
                                        <div class="form-group">
                                            <label> Branch Name</label>
                                            <input type="text" name="branch_name" id="branch_name" class="form-control"
                                                required data-parsley-maxlength="200" data-parsley-trigger="keyup"  />
                                        </div>
                                    </div>

                                    <div id="branchaddress" class="col-md-6" style="display: none">
                                        <div class="form-group">
                                            <label>Branch Address</label>
                                            <input type="text" name="branch_address" id="branch_address"
                                                class="form-control" required data-parsley-maxlength="250"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div> -->


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" name="companyemail" id="companyemail" class="form-control"
                                                required data-parsley-type="email" data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="companypassword" id="companypassword"
                                                class="form-control" required data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>GSTIN</label>
                                            <input type="text" name="companyGSTIN" id="companyGSTIN"
                                                class="form-control"  data-parsley-trigger="keyup" 
                                                pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <input type="text" name="companyBankName" id="companyBankName"
                                                class="form-control"  data-parsley-trigger="keyup" 
                                                />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank A/c Number</label>
                                            <input type="text" name="companyBankAccountNumber" id="companyBankAccountNumber"
                                                class="form-control"  data-parsley-trigger="keyup" 
                                                />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank IFSC</label>
                                            <input type="text" name="companyBankIFSC" id="companyBankIFSC"
                                                class="form-control"  data-parsley-trigger="keyup" 
                                                />
                                        </div>
                                    </div>

                                    <div class="col-md-12" align="center">
                                        <div class="form-group">
                                            <br />
                                            <button type="submit" name="register_button" id="register_button"
                                                class="btn btn-primary btn-user">Set Up</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
$(document).ready(function() {

            $("#companybranches").change(function() {
                debugger;
                    if (parseInt($(this).val()) > 0) {
                        $("#branch").show();
                        $("#branchaddress").show();
                    }
                });
            });
</script>
</body>

</html>


