<video autoplay muted loop id="vidback">
    <source src="assetss/background.mp4" type="video/mp4">
</video>
<div class="logo"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-offset-4 col-lg-4 ">
            <div class="alert alert-danger <?php echo $this->error['visible']; ?>">
                <strong>Warning!</strong> <?php echo $this->error['string'] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-offset-4 col-lg-4 ">
            <form class="form-horizontal formctr" action="./login" Method="POST">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="password" name="password" class="form-control" id="pwd" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-default btn-lg">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>