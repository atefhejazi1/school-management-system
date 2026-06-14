<style>
.admin-footer {
    margin-top: 12px;
    padding: 16px 24px;
    background: white;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.04);
}

.footer-copy {
    font-family: 'Cairo', sans-serif;
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
}
.footer-copy strong { color: #64748b; }

.footer-links {
    display: flex;
    gap: 0;
    list-style: none;
    padding: 0; margin: 0;
}
.footer-links li + li::before {
    content: '·';
    color: #cbd5e1;
    margin: 0 8px;
}
.footer-links a {
    font-family: 'Cairo', sans-serif;
    font-size: 12px;
    color: #94a3b8;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.footer-links a:hover { color: #3b82f6; }

.footer-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #16a34a;
    font-size: 11.5px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 10px;
    font-family: 'Cairo', sans-serif;
    animation: statusPulse 3s ease-in-out infinite;
}

.status-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #22c55e;
    animation: dotBlink 2s ease-in-out infinite;
}

@keyframes dotBlink {
    0%,100% { opacity: 1; }
    50%      { opacity: 0.4; }
}

@keyframes statusPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.15); }
    50%     { box-shadow: 0 0 0 4px rgba(34,197,94,0.08); }
}

@media (max-width: 576px) {
    .admin-footer { flex-direction: column; text-align: center; }
    .footer-links { justify-content: center; }
}
</style>

<footer class="admin-footer">
    <div class="footer-copy">
        <i class="fas fa-school" style="color:#3b82f6;"></i>
        &copy; <strong>نظام إدارة المدارس</strong>
        <span id="footer-year"></span> — جميع الحقوق محفوظة
    </div>

    <div class="footer-status">
        <div class="status-dot"></div>
        النظام يعمل بشكل طبيعي
    </div>

    <ul class="footer-links">
        <li><a href="#">شروط الاستخدام</a></li>
        <li><a href="#">سياسة الخصوصية</a></li>
        <li><a href="#">الدعم الفني</a></li>
    </ul>
</footer>

<script>
    document.getElementById('footer-year').textContent = new Date().getFullYear();
</script>
