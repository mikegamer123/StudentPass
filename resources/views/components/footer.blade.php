<footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">{{date("Y")}}  &copy; Copyright <a class="text-bold-800 grey darken-2" href="/admin" target="_blank">Student Pass</a></span>
        <ul class="list-inline float-md-right d-block d-md-inline-blockd-none d-lg-block mb-0">
            <li class="list-inline-item"><a class="my-1" href="https://themeselection.com/support" target="_blank"> Support</a></li>
         </ul>
    </div>
</footer>
<!-- BEGIN VENDOR JS-->
<script src="/storage/theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN JQUERY JS-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- BEGIN ADMIN  JS-->
<script src="/storage/theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<!-- END ADMIN  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script>
    $( document ).ready(function() {
        //disable number input to not be custom
        $("[type='number']").keypress(function (evt) {
            evt.preventDefault();
        });
        //delete button validation
        $(".delete-btn").click(function(e){
            e.preventDefault();
            var proceed = confirm("Da li ste sigurni?");
            if (proceed) {
                $(this).closest("form").submit();
            } else {
                //don't proceed
            }
        });
        <?php
        if(isset($_GET["message"])):?>
             $("#validation-modal").text(<?= $_GET["message"] ?>);
            $("#validation-modal").modal({
                    fadeDuration: 250
                });
        <?php endif;
        ?>
        //add page validation
        $(".add-btn").click(function(e){
            e.preventDefault();
            let filled = true;
            let phoneValid = true;
            let indexValid = true;
            let emailValid = true;
            $(".required").each(function (){
                if($(this).val() == "" || $(this).val() == null){
                  filled = false;
                }
            });
            let phoneRegex = new RegExp(/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im);
            $("input[name='phone']").each(function (){
                if(!phoneRegex.test($(this).val())){
                    phoneValid = false;
                }
                console.log("cao");
            });
            let isDigit = new RegExp(/^\d+$/);
            $("input[name='index']").each(function (){
                if(!isDigit.test($(this).val())){
                    indexValid = false;
                }
                console.log("cao");
            });
            var emailRegex =  new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
            $("input[name='email']").each(function (){
                if(!emailRegex.test($(this).val())){
                    emailValid = false;
                }
                console.log("cao");
            });
            if(!filled){
                $("#validation-modal").text("Molim vas popunite sva obavezna polja koja imaju zvezdice!");
                $($(this).data('modal')).modal({
                    fadeDuration: 250
                });
            }else
            if(!phoneValid){
                $("#validation-modal").text("Molim vas unesite važeći broj telefona!");
                $($(this).data('modal')).modal({
                    fadeDuration: 250
                });
            }else
            if(!indexValid){
                $("#validation-modal").text("Molim vas unesite važeći broj indeksa!");
                $($(this).data('modal')).modal({
                    fadeDuration: 250
                });
            }else
            if(!emailValid){
                $("#validation-modal").text("Molim vas unesite važeći email!");
                $($(this).data('modal')).modal({
                    fadeDuration: 250
                });
            }
            else{
                $(this).closest("form").submit();
            }
        });
    });

</script>
<!-- END PAGE LEVEL JS-->
</body>
</html>
