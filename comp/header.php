<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $this->title ?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <?php
    $t = time();
    for($i=0;$i<count($this->css);$i++) {
      echo "<link rel=\"stylesheet\" href=\"{$this->css[$i]}\">";
    }
    ?>
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="./">Flotsitime University</a>
            </div>
            <ul class="nav navbar-nav">
                <?php
                if ($this->nav["school"] == true) {
                    echo <<<XXX
                    <li class={$this->nav["active"]["school"]}>
                    <a href="/project/school">School</a>
                </li>
XXX;
                }
                if ($this->nav["admin"]) {
                    echo <<<YYY
                    <li class={$this->nav["active"]["admin"]}>
                    <a href="/project/admin">Administration</a>
                </li>
YYY;
                }
?>
            </ul>
            <?php
            if (isset($_SESSION['logged'])) {
                echo <<<XXX
                <div class="cred pull-right">
                <div class="passport">
                    <span class="name">{$_SESSION['logged']['name']}, {$_SESSION['logged']['role']}</span>
                    <a href="./logout">Logout</a>
                </div>
                <div class="credimg" style="background-image: url(upload/{$_SESSION['logged']['image']})"></div>
            </div>
XXX;
            }
            ?>
        </div>
    </nav>