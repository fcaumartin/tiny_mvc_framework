<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <hr>
    <?php echo $this->session->message; $this->session->message=null; ?>
    <hr>
    <a href="<?=url("")?>">Accueil</a>
        <a href="<?=url("crud/index")?>">CRUD</a>
        <a href="<?=url("test/test1")?>">Test1</a>
    <hr>