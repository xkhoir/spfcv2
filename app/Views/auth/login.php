<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('partial/meta'); ?>
</head>
<div id="tsparticles"></div>

<body class="hold-transition login-page">
    <div id="tsparticles" class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?php echo base_url(); ?>" class="h1"><b>Sistem Pakar</b>
                </a><br><br>
                <h6>Silahkan login terlebih dahulu untuk memakai aplikasi ini</h6>
            </div>
            <div class="card-body">
                <form id="login" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                    <div class="input-group mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-4"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <?= $this->include('partial/script'); ?>

    <script>
        $('#login').on('submit', function() {
            event.preventDefault();
            let _data = new FormData($(this)[0]);
            let _url = $(this).attr('action');
            send((data, xhr = null) => {
                if (data.status == 422) {
                    FailedNotif(data.messages);
                } else if (data.status == 200) {
                    Swal.fire({
                        type: 'success',
                        title: "Login Sukses",
                        text: data.messages,
                        timer: 3000,
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = data.url;
                    });
                }
            }, _url, 'json', 'post', _data);
        });

        $("#tsparticles")
            .particles()
            .init({
                    background: {
                        color: {
                            value: "#4b76bf",
                        },
                    },
                    fpsLimit: 60,
                    interactivity: {
                        events: {
                            onClick: {
                                enable: true,
                                mode: "push",
                            },
                            onHover: {
                                enable: false,
                                mode: "repulse",
                            },
                            resize: true,
                        },
                        modes: {
                            bubble: {
                                distance: 400,
                                duration: 2,
                                opacity: 0.8,
                                size: 40,
                            },
                            push: {
                                quantity: 4,
                            },
                            repulse: {
                                distance: 200,
                                duration: 0.4,
                            },
                        },
                    },
                    particles: {
                        color: {
                            value: "#ffffff",
                        },
                        links: {
                            color: "#ffffff",
                            distance: 150,
                            enable: true,
                            opacity: 0.5,
                            width: 1,
                        },
                        collisions: {
                            enable: true,
                        },
                        move: {
                            direction: "none",
                            enable: true,
                            outMode: "bounce",
                            random: false,
                            speed: 2,
                            straight: false,
                        },
                        number: {
                            density: {
                                enable: true,
                                value_area: 800,
                            },
                            value: 80,
                        },
                        opacity: {
                            value: 0.5,
                        },
                        shape: {
                            type: "circle",
                        },
                        size: {
                            random: true,
                            value: 5,
                        },
                    },
                    detectRetina: true,
                },
                function(container) {
                    // container is the particles container where you can play/pause or stop/start.
                    // the container is already started, you don't need to start it manually.
                }
            );
        // or

        // $("#tsparticles")
        //     .particles()
        //     .ajax("particles.json", function(container) {
        //         // container is the particles container where you can play/pause or stop/start.
        //         // the container is already started, you don't need to start it manually.
        //     });
    </script>

</body>

</html>