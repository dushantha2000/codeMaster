<div id="custom-loader" class="loader-overlay" style="display: none;">
    <div class="spinner"></div>
</div>

<style>

.loader-overlay {
    position: fixed;
    top: 0; left: 0; 
    width: 100%; height: 100%;
    background: rgba(10, 10, 15, 0.9);
    backdrop-filter: blur(10px);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.spinner {
    position: relative;
    width: 80px;
    height: 80px;
    border: 2px solid transparent;
    border-top: 3px solid #3b82f6; /* Blue glow */
    border-radius: 50%;
    animation: spin 1s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
    filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.6));
}

/* Inner ring spinning in reverse */
.spinner::before {
    content: "";
    position: absolute;
    top: 8px; left: 8px; right: 8px; bottom: 8px;
    border: 2px solid transparent;
    border-bottom: 3px solid #60a5fa;
    border-radius: 50%;
    animation: spin-reverse 0.8s linear infinite;
    opacity: 0.7;
}

/* Central core pulse */
.spinner::after {
    content: "";
    position: absolute;
    top: 25px; left: 25px; right: 25px; bottom: 25px;
    background: #3b82f6;
    border-radius: 50%;
    animation: core-pulse 1.5s ease-in-out infinite;
    box-shadow: 0 0 20px #3b82f6;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes spin-reverse {
    0% { transform: rotate(360deg); }
    100% { transform: rotate(0deg); }
}

@keyframes core-pulse {
    0%, 100% { transform: scale(0.8); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 1; }
}
</style>
