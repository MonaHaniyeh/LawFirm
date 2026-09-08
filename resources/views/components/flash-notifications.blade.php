{{--
============================================================
LAW FIRM - GLOBAL FLASH NOTIFICATIONS
resources/views/components/flash-notifications.blade.php
============================================================
--}}
@if (
    session()->has('success') ||
    session()->has('error') ||
    session()->has('warning') ||
    session()->has('info') ||
    session()->has('status')
)
    @php
        $notifications = [
            'success' => session('success'),
            'error' => session('error'),
            'warning' => session('warning'),
            'info' => session('info'),
            'status' => session('status'),
        ];
    @endphp

    <div
        id="lawfirm-notifications"
        class="lawfirm-notifications"
        aria-live="polite"
        aria-atomic="true"
    >
        @foreach ($notifications as $type => $message)
            @if ($message)
                @php
                    $config = match ($type) {
                        'success' => [
                            'icon' => 'check',
                            'label' => 'Success',
                        ],
                        'error' => [
                            'icon' => 'error',
                            'label' => 'Error',
                        ],
                        'warning' => [
                            'icon' => 'warning',
                            'label' => 'Warning',
                        ],
                        'info' => [
                            'icon' => 'info',
                            'label' => 'Information',
                        ],
                        'status' => [
                            'icon' => 'check',
                            'label' => 'Success',
                        ],
                        default => [
                            'icon' => 'info',
                            'label' => 'Notification',
                        ],
                    };
                @endphp

                <div
                    class="lawfirm-toast lawfirm-toast-{{ $type }}"
                    role="alert"
                    data-duration="5000"
                >
                    {{-- Left Accent --}}
                    <div class="lawfirm-toast-accent"></div>

                    {{-- Icon --}}
                    <div class="lawfirm-toast-icon">
                        @if ($config['icon'] === 'check')
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M5 12.5L9.5 17L19 7.5"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        @elseif ($config['icon'] === 'error')
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke="currentColor"
                                    stroke-width="2"
                                />
                                <path
                                    d="M12 7.5V12.5"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />
                                <circle cx="12" cy="16" r="1" fill="currentColor" />
                            </svg>
                        @elseif ($config['icon'] === 'warning')
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M12 4L21 19H3L12 4Z"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="M12 9V13"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />
                                <circle cx="12" cy="16" r="1" fill="currentColor" />
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke="currentColor"
                                    stroke-width="2"
                                />
                                <path
                                    d="M12 10V16"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />
                                <circle cx="12" cy="7" r="1" fill="currentColor" />
                            </svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="lawfirm-toast-content">
                        <div class="lawfirm-toast-label">
                            {{ $config['label'] }}
                        </div>

                        <div class="lawfirm-toast-message">
                            {{ $message }}
                        </div>
                    </div>

                    {{-- Close --}}
                    <button
                        type="button"
                        class="lawfirm-toast-close"
                        aria-label="Close notification"
                        onclick="closeLawFirmToast(this)"
                    >
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M6 6L18 18"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                            <path
                                d="M18 6L6 18"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>
                    </button>

                    {{-- Progress --}}
                    <div class="lawfirm-toast-progress"></div>
                </div>
            @endif
        @endforeach
    </div>
@endif

<style>
    /* =========================================================
       CONTAINER
       ========================================================= */
    .lawfirm-notifications {
        position: fixed;
        top: 24px;
        right: 24px;
        width: min(420px, calc(100vw - 32px));
        display: flex;
        flex-direction: column;
        gap: 12px;
        z-index: 99999;
        pointer-events: none;
    }

    /* =========================================================
       TOAST
       ========================================================= */
    .lawfirm-toast {
        position: relative;
        display: flex;
        align-items: flex-start;
        min-height: 82px;
        background: #151515;
        border: 1px solid rgba(255, 255, 255, 0.10);
        box-shadow:
            0 18px 45px rgba(0, 0, 0, 0.20),
            0 4px 12px rgba(0, 0, 0, 0.10);
        overflow: hidden;
        pointer-events: auto;
        animation: lawfirmToastIn 0.45s cubic-bezier(.22, .8, .25, 1) forwards;
    }

    .lawfirm-toast.is-closing {
        animation: lawfirmToastOut 0.35s ease forwards;
    }

    /* =========================================================
       GOLD ACCENT
       ========================================================= */
    .lawfirm-toast-accent {
        width: 4px;
        align-self: stretch;
        flex-shrink: 0;
        background: #b69a68;
    }

    /* =========================================================
       ICON
       ========================================================= */
    .lawfirm-toast-icon {
        width: 40px;
        height: 40px;
        margin: 20px 14px 20px 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(182, 154, 104, 0.35);
        background: rgba(182, 154, 104, 0.08);
        color: #b69a68;
    }

    .lawfirm-toast-icon svg {
        width: 21px;
        height: 21px;
    }

    /* =========================================================
       CONTENT
       ========================================================= */
    .lawfirm-toast-content {
        flex: 1;
        min-width: 0;
        padding: 17px 8px 17px 0;
    }

    .lawfirm-toast-label {
        margin-bottom: 4px;
        color: #b69a68;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .lawfirm-toast-message {
        color: #f7f4ed;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.55;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    /* =========================================================
       CLOSE BUTTON
       ========================================================= */
    .lawfirm-toast-close {
        width: 38px;
        height: 38px;
        margin: 14px 10px 0 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        background: transparent;
        color: #77736c;
        cursor: pointer;
        transition:
            color 0.2s ease,
            background 0.2s ease;
    }

    .lawfirm-toast-close:hover {
        color: #f7f4ed;
        background: rgba(255, 255, 255, 0.06);
    }

    .lawfirm-toast-close svg {
        width: 17px;
        height: 17px;
    }

    /* =========================================================
       TYPES
       ========================================================= */
    .lawfirm-toast-success .lawfirm-toast-accent {
        background: #b69a68;
    }

    .lawfirm-toast-error .lawfirm-toast-accent {
        background: #b86b68;
    }

    .lawfirm-toast-warning .lawfirm-toast-accent {
        background: #c49a58;
    }

    .lawfirm-toast-info .lawfirm-toast-accent {
        background: #72869a;
    }

    .lawfirm-toast-error .lawfirm-toast-icon {
        color: #d58a86;
        border-color: rgba(213, 138, 134, 0.30);
        background: rgba(213, 138, 134, 0.08);
    }

    .lawfirm-toast-warning .lawfirm-toast-icon {
        color: #d1aa68;
        border-color: rgba(209, 170, 104, 0.30);
        background: rgba(209, 170, 104, 0.08);
    }

    .lawfirm-toast-info .lawfirm-toast-icon {
        color: #9aaebe;
        border-color: rgba(154, 174, 190, 0.30);
        background: rgba(154, 174, 190, 0.08);
    }

    /* =========================================================
       PROGRESS BAR
       ========================================================= */
    .lawfirm-toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 100%;
        background: #b69a68;
        transform-origin: left;
        animation: lawfirmToastProgress 5s linear forwards;
    }

    .lawfirm-toast-error .lawfirm-toast-progress {
        background: #b86b68;
    }

    .lawfirm-toast-warning .lawfirm-toast-progress {
        background: #c49a58;
    }

    .lawfirm-toast-info .lawfirm-toast-progress {
        background: #72869a;
    }

    /* =========================================================
       ANIMATIONS
       ========================================================= */
    @keyframes lawfirmToastIn {
        from {
            opacity: 0;
            transform: translateX(35px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes lawfirmToastOut {
        from {
            opacity: 1;
            transform: translateX(0);
            max-height: 120px;
            margin-bottom: 0;
        }
        to {
            opacity: 0;
            transform: translateX(35px);
            max-height: 0;
            min-height: 0;
            margin-bottom: -12px;
        }
    }

    @keyframes lawfirmToastProgress {
        from {
            transform: scaleX(1);
        }
        to {
            transform: scaleX(0);
        }
    }

    /* =========================================================
       MOBILE
       ========================================================= */
    @media (max-width: 640px) {
        .lawfirm-notifications {
            top: 12px;
            right: 12px;
            left: 12px;
            width: auto;
        }

        .lawfirm-toast {
            min-height: 76px;
        }

        .lawfirm-toast-icon {
            width: 36px;
            height: 36px;
            margin: 18px 11px 18px 13px;
        }

        .lawfirm-toast-content {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .lawfirm-toast-message {
            font-size: 12px;
        }
    }

    /* =========================================================
       REDUCED MOTION
       ========================================================= */
    @media (prefers-reduced-motion: reduce) {
        .lawfirm-toast {
            animation: none;
        }

        .lawfirm-toast-progress {
            animation: none;
        }
    }
</style>

<script>
    /* =========================================================
       LAW FIRM GLOBAL NOTIFICATION SYSTEM
       ========================================================= */
    function closeLawFirmToast(button) {
        const toast = button.closest('.lawfirm-toast');

        if (!toast) {
            return;
        }

        toast.classList.add('is-closing');

        setTimeout(() => {
            toast.remove();
        }, 350);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const notifications = document.querySelectorAll('.lawfirm-toast');

        notifications.forEach(function (toast) {
            const duration = parseInt(
                toast.dataset.duration || 5000,
                10
            );

            setTimeout(function () {
                if (!toast.classList.contains('is-closing')) {
                    toast.classList.add('is-closing');

                    setTimeout(function () {
                        toast.remove();
                    }, 350);
                }
            }, duration);
        });
    });
</script>
