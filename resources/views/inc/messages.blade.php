<script>
setTimeout(function() {
    $('#div').fadeOut('fast');
}, 5000);
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php
if(count($errors)>0){
    foreach($errors->all() as $error){
        ?>
    <div class="alert-danger" id="div" style="border-radius:5px;padding-left:10px;margin-left: 17px;margin-right: 17px ">
           <i class="fa fa-times-circle"></i>
           <p style="padding-left:5px; display:inline; ">{{$error}}</p>
        </div>
<?php        
    }
}
if(session('success')){
    ?>
    <div class="alert-success" id="div" style="border-radius:5px;padding-left:10px;margin-left: 17px;margin-right: 17px ">
        <i class="fa fa-check"></i>
        <p style="padding-left:5px; display:inline; ">{{session('success')}}</p>
        </div>
<?php
}
if(session('error')){
    ?>
    <div class="alert-danger" id="div" style="border-radius:5px;padding-left:10px;margin-left: 17px;margin-right: 17px ">
        <i class="fa fa-times-circle"></i>
        <p style="padding-left:5px; display:inline; ">{{session('error')}}</p>
    </div>
<?php } ?>
