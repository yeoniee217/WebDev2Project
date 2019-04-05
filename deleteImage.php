 <?php 
    session_start();

    if(isset($_POST['delete'])) {
        $file = $_SESSION['id'];
        unlink('uploads/' . $file .'.png');

        header("Location:myAccount.php");
        exit;
    }
?>