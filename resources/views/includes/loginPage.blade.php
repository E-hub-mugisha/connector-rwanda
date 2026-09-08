<!-- Login Modal -->
<div class="modal fade connector-login-modal"
     id="loginModal"
     tabindex="-1"
     aria-labelledby="loginModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content connector-login-content">

            <!-- Close -->
            <button type="button"
                    class="connector-modal-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="connector-login-layout">

                <!-- Left Brand Panel -->
                <div class="connector-login-brand">

                    <div class="connector-brand-inner">

                        <div class="connector-brand-mark">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </div>

                        <span class="connector-brand-name">
                            Connector
                        </span>

                        <div class="connector-brand-copy">
                            <span class="connector-brand-eyebrow">
                                CONNECTOR MARKETPLACE
                            </span>

                            <h3>
                                Connect with the right
                                <span>professionals.</span>
                            </h3>

                            <p>
                                Discover trusted services and connect
                                directly with professionals who can get
                                the job done.
                            </p>
                        </div>

                        <div class="connector-brand-features">

                            <div class="connector-feature">
                                <div class="connector-feature-icon">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div>
                                    <strong>Find services</strong>
                                    <small>Discover professionals near you</small>
                                </div>
                            </div>

                            <div class="connector-feature">
                                <div class="connector-feature-icon">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <div>
                                    <strong>Connect directly</strong>
                                    <small>Communicate with service providers</small>
                                </div>
                            </div>

                            <div class="connector-feature">
                                <div class="connector-feature-icon">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div>
                                    <strong>Get it done</strong>
                                    <small>Choose the right professional</small>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Login Form -->
                <div class="connector-login-form">

                    <div class="connector-login-header">

                        <div class="connector-mobile-logo">
                            <div class="connector-brand-mark">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </div>
                            <span>Connector</span>
                        </div>

                        <h2 id="loginModalLabel">
                            Welcome back
                        </h2>

                        <p>
                            Sign in to continue to your account.
                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('login') }}"
                          class="connector-form">

                        @csrf

                        <!-- Email -->
                        <div class="connector-form-group">

                            <label for="login_email">
                                Email address
                            </label>

                            <div class="connector-input-wrapper">

                                <i class="bi bi-envelope connector-input-icon"></i>

                                <input
                                    type="email"
                                    id="login_email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="@error('email') is-invalid @enderror"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >

                            </div>

                            @error('email')
                                <div class="connector-error">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror

                        </div>

                        <!-- Password -->
                        <div class="connector-form-group">

                            <div class="connector-label-row">
                                <label for="login_password">
                                    Password
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="connector-forgot">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <div class="connector-input-wrapper">

                                <i class="bi bi-lock connector-input-icon"></i>

                                <input
                                    type="password"
                                    id="login_password"
                                    name="password"
                                    class="@error('password') is-invalid @enderror"
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    required
                                >

                                <button type="button"
                                        class="connector-password-toggle"
                                        data-target="login_password"
                                        aria-label="Show password">
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                            @error('password')
                                <div class="connector-error">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror

                        </div>

                        <!-- Remember -->
                        <div class="connector-login-options">

                            <label class="connector-checkbox">

                                <input
                                    type="checkbox"
                                    id="remember_me"
                                    name="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >

                                <span class="connector-checkmark"></span>

                                <span>Keep me logged in</span>

                            </label>

                        </div>

                        <!-- Login -->
                        <button type="submit"
                                class="connector-login-button">

                            <span>Sign in</span>

                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </form>

                    <!-- Divider -->
                    <div class="connector-divider">
                        <span></span>
                        <small>OR CONTINUE WITH</small>
                        <span></span>
                    </div>

                    <!-- Social Login -->
                    <div class="connector-social-grid">

                        <a href="#"
                           class="connector-social-button">

                            <img
                                src="{{ asset('asset/images/icon/google.png') }}"
                                alt="Google"
                            >

                            <span>Google</span>

                        </a>

                        <a href="#"
                           class="connector-social-button">

                            <img
                                src="{{ asset('asset/images/icon/facebook.png') }}"
                                alt="Facebook"
                            >

                            <span>Facebook</span>

                        </a>

                    </div>

                    <!-- Register -->
                    <div class="connector-register">
                        <span>Don't have an account?</span>

                        <a href="{{ route('register') }}">
                            Create an account
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<style>
/* =========================================================
   CONNECTOR LOGIN MODAL
   ========================================================= */

.connector-login-modal {
    --connector-primary: #6B9080;
    --connector-primary-dark: #254035;
    --connector-primary-soft: #EEF4F1;
    --connector-text: #183028;
    --connector-muted: #718078;
    --connector-border: #E1EAE6;
    --connector-bg: #F7FAF8;
}


/* ---------------------------------------------------------
   Modal
   --------------------------------------------------------- */

.connector-login-modal .modal-dialog {
    max-width: 980px;
    width: calc(100% - 32px);
}

.connector-login-content {
    position: relative;
    overflow: hidden;
    padding: 0;
    border: 0;
    border-radius: 22px;
    background: #fff;
    box-shadow: 0 30px 80px rgba(37, 64, 53, 0.20);
}


/* ---------------------------------------------------------
   Close Button
   --------------------------------------------------------- */

.connector-modal-close {
    position: absolute;
    top: 18px;
    right: 18px;
    z-index: 20;

    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.20);
    border-radius: 50%;

    background: rgba(255, 255, 255, 0.10);
    color: #fff;

    cursor: pointer;

    transition: all .2s ease;
}

.connector-modal-close:hover {
    background: rgba(255, 255, 255, 0.20);
    transform: rotate(90deg);
}


/* ---------------------------------------------------------
   Layout
   --------------------------------------------------------- */

.connector-login-layout {
    display: grid;
    grid-template-columns: 42% 58%;
    min-height: 610px;
}


/* ---------------------------------------------------------
   Brand Panel
   --------------------------------------------------------- */

.connector-login-brand {
    position: relative;
    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            #254035 0%,
            #315747 55%,
            #6B9080 100%
        );

    color: #fff;
}

.connector-login-brand::before {
    content: "";
    position: absolute;

    width: 280px;
    height: 280px;

    top: -140px;
    right: -140px;

    border: 1px solid rgba(255,255,255,.12);
    border-radius: 50%;
}

.connector-login-brand::after {
    content: "";
    position: absolute;

    width: 360px;
    height: 360px;

    bottom: -220px;
    left: -180px;

    border: 1px solid rgba(255,255,255,.08);
    border-radius: 50%;
}

.connector-brand-inner {
    position: relative;
    z-index: 2;

    height: 100%;

    display: flex;
    flex-direction: column;

    padding: 42px 38px;
}


/* ---------------------------------------------------------
   Logo
   --------------------------------------------------------- */

.connector-brand-mark {
    width: 42px;
    height: 42px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.18);

    color: #fff;
    font-size: 17px;
}

.connector-brand-name {
    margin-top: 12px;

    font-size: 20px;
    font-weight: 700;
    letter-spacing: -.5px;
}


/* ---------------------------------------------------------
   Brand Copy
   --------------------------------------------------------- */

.connector-brand-copy {
    margin-top: auto;
    margin-bottom: auto;
    padding: 55px 0 45px;
}

.connector-brand-eyebrow {
    display: inline-block;

    margin-bottom: 18px;

    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.8px;

    color: rgba(255,255,255,.65);
}

.connector-brand-copy h3 {
    max-width: 320px;

    margin: 0 0 18px;

    font-size: 34px;
    line-height: 1.12;
    letter-spacing: -1.3px;
    font-weight: 700;
}

.connector-brand-copy h3 span {
    color: #DCEBE4;
}

.connector-brand-copy p {
    max-width: 320px;

    margin: 0;

    font-size: 14px;
    line-height: 1.7;

    color: rgba(255,255,255,.72);
}


/* ---------------------------------------------------------
   Features
   --------------------------------------------------------- */

.connector-brand-features {
    display: flex;
    flex-direction: column;
    gap: 13px;
}

.connector-feature {
    display: flex;
    align-items: center;
    gap: 12px;
}

.connector-feature-icon {
    flex: 0 0 34px;

    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(255,255,255,.10);

    color: #fff;
    font-size: 14px;
}

.connector-feature strong {
    display: block;

    font-size: 12px;
    font-weight: 600;

    color: #fff;
}

.connector-feature small {
    display: block;

    margin-top: 2px;

    font-size: 10px;

    color: rgba(255,255,255,.55);
}


/* ---------------------------------------------------------
   Form Side
   --------------------------------------------------------- */

.connector-login-form {
    padding: 52px 58px 42px;

    background: #fff;
}

.connector-login-header {
    margin-bottom: 30px;
}

.connector-login-header h2 {
    margin: 0 0 8px;

    color: var(--connector-text);

    font-size: 29px;
    line-height: 1.2;
    font-weight: 700;
    letter-spacing: -.8px;
}

.connector-login-header p {
    margin: 0;

    color: var(--connector-muted);

    font-size: 13px;
}


/* Mobile logo */

.connector-mobile-logo {
    display: none;
}


/* ---------------------------------------------------------
   Form
   --------------------------------------------------------- */

.connector-form-group {
    margin-bottom: 21px;
}

.connector-form-group label {
    display: block;

    margin-bottom: 8px;

    color: var(--connector-text);

    font-size: 12px;
    font-weight: 600;
}

.connector-label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.connector-label-row label {
    margin-bottom: 8px;
}

.connector-forgot {
    margin-bottom: 8px;

    color: var(--connector-primary);

    font-size: 11px;
    font-weight: 600;

    text-decoration: none;

    transition: color .2s ease;
}

.connector-forgot:hover {
    color: var(--connector-primary-dark);
}


/* ---------------------------------------------------------
   Inputs
   --------------------------------------------------------- */

.connector-input-wrapper {
    position: relative;
}

.connector-input-wrapper input {
    width: 100%;
    height: 50px;

    padding: 0 45px 0 43px;

    border: 1px solid var(--connector-border);
    border-radius: 10px;

    background: #FBFCFC;

    color: var(--connector-text);

    font-family: inherit;
    font-size: 13px;

    outline: none;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.connector-input-wrapper input::placeholder {
    color: #A2AEA9;
}

.connector-input-wrapper input:hover {
    border-color: #CAD8D2;
}

.connector-input-wrapper input:focus {
    border-color: var(--connector-primary);

    background: #fff;

    box-shadow: 0 0 0 3px rgba(107, 144, 128, .10);
}

.connector-input-icon {
    position: absolute;

    left: 16px;
    top: 50%;

    transform: translateY(-50%);

    z-index: 2;

    color: #8B9993;

    font-size: 15px;

    pointer-events: none;
}


/* Password toggle */

.connector-password-toggle {
    position: absolute;

    right: 13px;
    top: 50%;

    width: 28px;
    height: 28px;

    display: flex;
    align-items: center;
    justify-content: center;

    transform: translateY(-50%);

    border: 0;
    background: transparent;

    color: #899791;

    cursor: pointer;

    transition: color .2s ease;
}

.connector-password-toggle:hover {
    color: var(--connector-primary-dark);
}


/* ---------------------------------------------------------
   Error
   --------------------------------------------------------- */

.connector-error {
    display: flex;
    align-items: center;
    gap: 5px;

    margin-top: 7px;

    color: #C84E4E;

    font-size: 11px;
}

.connector-input-wrapper input.is-invalid {
    border-color: #D66B6B;
}


/* ---------------------------------------------------------
   Remember
   --------------------------------------------------------- */

.connector-login-options {
    margin: 1px 0 20px;
}

.connector-checkbox {
    display: inline-flex !important;
    align-items: center;
    gap: 8px;

    margin: 0 !important;

    color: #68766F !important;

    font-size: 11px !important;
    font-weight: 400 !important;

    cursor: pointer;
}

.connector-checkbox input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.connector-checkmark {
    width: 16px;
    height: 16px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border: 1px solid #CBD7D2;
    border-radius: 4px;

    background: #fff;

    transition: all .2s ease;
}

.connector-checkbox input:checked + .connector-checkmark {
    border-color: var(--connector-primary);
    background: var(--connector-primary);
}

.connector-checkbox input:checked + .connector-checkmark::after {
    content: "✓";

    color: #fff;

    font-size: 10px;
    font-weight: 700;
}


/* ---------------------------------------------------------
   Login Button
   --------------------------------------------------------- */

.connector-login-button {
    width: 100%;
    height: 50px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

    border: 0;
    border-radius: 10px;

    background: var(--connector-primary-dark);

    color: #fff;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    box-shadow: 0 8px 18px rgba(37, 64, 53, .14);

    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.connector-login-button i {
    font-size: 15px;

    transition: transform .2s ease;
}

.connector-login-button:hover {
    background: #1D342B;

    transform: translateY(-1px);

    box-shadow: 0 10px 24px rgba(37, 64, 53, .18);
}

.connector-login-button:hover i {
    transform: translateX(3px);
}


/* ---------------------------------------------------------
   Divider
   --------------------------------------------------------- */

.connector-divider {
    display: flex;
    align-items: center;
    gap: 12px;

    margin: 27px 0 17px;
}

.connector-divider span {
    flex: 1;

    height: 1px;

    background: #E8EEEB;
}

.connector-divider small {
    color: #98A39E;

    font-size: 9px;
    font-weight: 600;
    letter-spacing: .8px;
}


/* ---------------------------------------------------------
   Social Buttons
   --------------------------------------------------------- */

.connector-social-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;

    gap: 10px;
}

.connector-social-button {
    height: 46px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;

    border: 1px solid var(--connector-border);
    border-radius: 9px;

    background: #fff;

    color: #43534C;

    font-size: 12px;
    font-weight: 600;

    text-decoration: none;

    transition:
        border-color .2s ease,
        background .2s ease,
        transform .2s ease;
}

.connector-social-button img {
    width: 17px;
    height: 17px;

    object-fit: contain;
}

.connector-social-button:hover {
    border-color: #C9D7D1;
    background: #F9FBFA;

    color: var(--connector-primary-dark);

    transform: translateY(-1px);
}


/* ---------------------------------------------------------
   Register
   --------------------------------------------------------- */

.connector-register {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;

    margin-top: 27px;

    font-size: 11px;

    color: #8A9691;
}

.connector-register a {
    display: inline-flex;
    align-items: center;
    gap: 3px;

    color: var(--connector-primary-dark);

    font-weight: 700;

    text-decoration: none;
}

.connector-register a i {
    font-size: 9px;
}

.connector-register a:hover {
    color: var(--connector-primary);
}


/* ---------------------------------------------------------
   Bootstrap modal backdrop
   --------------------------------------------------------- */

.connector-login-modal.show {
    backdrop-filter: blur(4px);
}

.connector-login-modal .modal-backdrop {
    background: #14251F;
}


/* ---------------------------------------------------------
   Responsive
   --------------------------------------------------------- */

@media (max-width: 900px) {

    .connector-login-modal .modal-dialog {
        max-width: 520px;
    }

    .connector-login-layout {
        grid-template-columns: 1fr;
        min-height: auto;
    }

    .connector-login-brand {
        display: none;
    }

    .connector-login-form {
        padding: 42px 42px 35px;
    }

    .connector-mobile-logo {
        display: flex;
        align-items: center;
        gap: 10px;

        margin-bottom: 28px;
    }

    .connector-mobile-logo .connector-brand-mark {
        width: 38px;
        height: 38px;

        background: var(--connector-primary-soft);

        color: var(--connector-primary-dark);
    }

    .connector-mobile-logo span {
        color: var(--connector-primary-dark);

        font-size: 18px;
        font-weight: 700;
    }

    .connector-modal-close {
        background: #F3F6F4;
        border-color: #E0E8E4;
        color: var(--connector-primary-dark);
    }

    .connector-modal-close:hover {
        background: #E8EFEB;
    }
}


@media (max-width: 576px) {

    .connector-login-modal .modal-dialog {
        width: calc(100% - 20px);
        margin: 10px auto;
    }

    .connector-login-content {
        border-radius: 17px;
    }

    .connector-login-form {
        padding: 32px 22px 28px;
    }

    .connector-login-header {
        margin-bottom: 25px;
        padding-right: 25px;
    }

    .connector-login-header h2 {
        font-size: 25px;
    }

    .connector-social-grid {
        grid-template-columns: 1fr;
    }

    .connector-social-button {
        height: 44px;
    }

    .connector-register {
        flex-direction: column;
        gap: 3px;
    }

    .connector-form-group {
        margin-bottom: 18px;
    }
}


/* ---------------------------------------------------------
   Reduced Motion
   --------------------------------------------------------- */

@media (prefers-reduced-motion: reduce) {

    .connector-login-modal *,
    .connector-login-modal *::before,
    .connector-login-modal *::after {
        transition: none !important;
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
     * Password visibility toggle
     */
    document.querySelectorAll('.connector-password-toggle').forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (!input) {
                return;
            }

            const icon = this.querySelector('i');

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

                this.setAttribute('aria-label', 'Hide password');

            } else {

                input.type = 'password';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

                this.setAttribute('aria-label', 'Show password');
            }

        });

    });

});
</script>