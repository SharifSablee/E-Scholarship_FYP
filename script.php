    <!-- jQuery Library -->
    <script src="bootstrap/js/jquery-3.3.1.slim.min.js"></script>
    
    <!-- popper, required for animations -->
    <script src="bootstrap/js/popper.min.js"></script>
    
    <!-- bootstrap javascript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jquery cdn -->
    <script src="js/jquery.min.js"></script>

    <!-- datepicker js -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap-datepicker.min.js"></script>    

    <!-- sweetalert -->
    <script src="js/sweetalert.min.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script type="text/javascript" charset="utf8" src="sweetalert2/sweetalert2.js"></script>

    <!-- ajax -->
    <script src="ajax/jquery.min.js"></script>
    <script src="ajax/sweetalert.min.js"></script>

    <?php
        if(isset($_SESSION['status']) && $_SESSION['status'] != '') {
            ?>
            <script>
                Swal.fire({
                    'title': '<?php echo $_SESSION['status_title']; ?>',
                    'text': '<?php echo $_SESSION['status']; ?>',
                    'icon': '<?php echo $_SESSION['status_code']; ?>',
                    'showConfirmButton': false,
                    'timer': 2000,
                });
            </script>
            <?php
            unset($_SESSION['status']);
        }
    ?>

    <!-- toggle password -->
    <script>
    $(".toggle-password").click(function() {
        $(this).toggleClass(".fa fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
    });
    </script>
    

    
    
