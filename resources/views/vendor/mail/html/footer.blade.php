<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center" style="color: #9ca3af; font-size: 12px; line-height: 1.8;">
    <p style="margin: 0; letter-spacing: 1px; text-transform: uppercase; font-size: 11px; font-weight: 700; color: #b11d40; margin-bottom: 8px;">
        Luxury Travel Management
    </p>
    <p style="margin: 0; font-weight: 700; color: #6b7280;">
        © {{ date('Y') }} ACCESS MOROCCO.
    </p>
    <p style="margin: 2px 0 0 0;">
        Casablanca, Morocco
    </p>
    {{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
