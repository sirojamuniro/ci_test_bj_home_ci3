<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <p class="mb-0"><?php echo $this->session->flashdata('message'); ?></p>
</div>
<?php } ?>
<div id="home" class="intro route bg-image"
    style="background-image: url(<?php echo base_url(); ?>assets_frontend/img/3.jpeg)">
    <div class="overlay-itro"></div>
    <div class="intro-content display-table">
        <div class="table-cell">
            <div class="container">
                <h1 class="intro-title mb-4">Siroja Muniro</h1>
                <p class="intro-subtitle"><span>Web Developer, Web Designer, Fullstack Developer
                    </span><strong class="text-slider"></strong></p>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>
</div>
<div class="container">
    <form action="<?= base_url('auth'); ?>" method="POST">
        <div class="form-group">
            <label class="col-form-label" for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" id="username" required="">
        </div>
        <div class="form-group">
            <label class="col-form-label" for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password" id="password"
                required="">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>