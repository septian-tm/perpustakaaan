<?php
if (isset($_POST['daftar'])) {
    if (daftarUser($_POST) > 0) {
    }
}
if (isset($_POST['masuk'])) {
    if (masuk($_POST) > 0) {
    }
} ?>

<div class="card-daftar">
    <!-- Pills navs -->
    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-login" data-bs-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-register" data-bs-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
        </li>
    </ul>
    <!-- Pills navs -->

    <!-- Pills content -->
    <div class="tab-content">
        <!-- tab login/masuk -->
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <form method="post">
                <!-- Email input -->
                <div class="input-box mb-4">
                    <input type="text" id="un" placeholder=" " class="form-control" name="un" autocomplete="off"/>
                    <label class="form-label" for="un">Username or Nis</label>
                </div>

                <!-- Password input -->
                <div class="input-box mb-4">
                    <input type="password" id="loginPassword" placeholder=" " class="form-control  password-input" name="pw" />
                    <label class="form-label" for="loginPassword">Password</label>
                    <i class="fa-solid fa-eye-slash" id="toggle-icon" onclick="togglePassword()"></i>
                </div>

                <!-- Submit button -->
                <button type=" submit" class="btn btn-primary btn-block mb-4" name="masuk">
                    Sign in
                </button>

                <!-- Register buttons -->
                <div class="text-center">
                    <p>Not a member? <a href="#!">Register</a></p>
                </div>
            </form>
        </div>

        <!-- DAFTAR -->
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
            <form method="post">
                <!-- Name input -->
                <div class="input-box">
                    <input type="text" id="registerName" placeholder=" " class="form-control" name="nama" required />
                    <label class="form-label" for="registerName">Name</label>
                </div>

                <div class="row">
                    <div class="col">
                        <!-- Username input -->
                        <div class="input-box">
                            <input type="text" id="registerUsername" placeholder=" " class="form-control" name="username" required />
                            <label class="form-label" for="registerUsername">Username</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Nis input -->
                        <div class="input-box">
                            <input type="number" id="nis" placeholder=" " class="form-control" name="nis" required />
                            <label class="form-label" for="nis">Nis</label>
                        </div>
                    </div>
                </div>

                <!-- JK input -->
                <div class="input-box mb-4">
                    <select name="jk" id="jk" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <option value="Laki-laki">L</option>
                        <option value="Perempuan">P</option>
                    </select>
                    <label class="form-label" for="jk">Jenis Kelamin</label>
                </div>

                <!-- Tgl Lahir input -->
                <div class="input-box mb-4">
                    <input type="date" id="tgl" placeholder=" " class="form-control" name="tgl" required />
                    <label class="form-label" for="tgl">Tanggal Lahir</label>
                </div>

                <!-- hp input -->
                <div class="input-box mb-4">
                    <input type="number" id="hp" placeholder=" " class="form-control" name="nohp" required />
                    <label class="form-label" for="hp">No Hp</label>
                </div>

                <!-- Alamat input -->
                <div class="input-box mb-4">
                    <textarea id="alamat" placeholder=" " class="form-control" rows="3" name="alamat" required></textarea>
                    <label class="form-label" for="alamat">Alamat</label>
                </div>

                <!-- Password input -->
                <div class="input-box mb-4">
                    <input type="password" id="registerPassword" placeholder=" " class="form-control password-input" name="pw1" minLength="5" required/>
                    <label class="form-label" for="registerPassword">Password</label>
                </div>

                <!-- Repeat Password input -->
                <div class="input-box mb-2">
                    <input type="password" id="registerRepeatPassword" placeholder=" " class="form-control password-input" name="pw2" required />
                    <label class="form-label" for="registerRepeatPassword">Ulangi password</label>
                </div>
                <div class="mb-3">
                    <input type="checkbox" id="toggle-icon" onclick="togglePassword()"/> Show password
                </div>
                <!-- Checkbox -->

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-3" name="daftar">
                    Daftar
                </button>
            </form>
        </div>
    </div>
</div>