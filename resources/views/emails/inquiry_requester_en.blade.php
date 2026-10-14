<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Confirmation & Acknowledgment - Islenesia Export Desk</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F8FAFC; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1E293B;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 28px 12px;">
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; background-color: #FFFFFF; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(11,27,61,0.08); border: 1px solid #E2E8F0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0B1B3D; padding: 32px 36px; border-bottom: 3px solid #D4AF37;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div style="font-size: 26px; font-weight: 800; color: #D4AF37; letter-spacing: 0.5px; margin: 0;">
                                            {{ strtoupper($siteSettings['site_name'] ?? 'ISLENESIA') }}
                                        </div>
                                        <div style="font-size: 13px; color: #E2E8F0; margin-top: 4px; letter-spacing: 0.3px;">
                                            {{ $siteSettings['company_name'] ?? 'PT Islenesia Agro Nusantara' }} • Indonesia
                                        </div>
                                    </td>
                                    <td align="right" valign="middle">
                                        <div style="background-color: rgba(212, 175, 55, 0.15); border: 1px solid #D4AF37; color: #D4AF37; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Ref: #ISL-{{ $inquiry->id }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Verified Badge Banner -->
                    <tr>
                        <td style="background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; padding: 12px 36px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="font-size: 12px; color: #475569; font-weight: 600;">
                                        <span style="color: #D4AF37;">★</span> Official Agro Commodity Export Desk &bull; Phytosanitary & QC Compliant
                                    </td>
                                    <td align="right" style="font-size: 12px; color: #64748B;">
                                        {{ now()->format('M d, Y') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Body Content -->
                    <tr>
                        <td style="padding: 36px;">
                            <h2 style="font-size: 20px; color: #0B1B3D; margin-top: 0; margin-bottom: 16px; font-weight: 700;">
                                Trade Inquiry Acknowledgment
                            </h2>

                            <p style="font-size: 15px; line-height: 1.7; color: #334155; margin-top: 0; margin-bottom: 16px;">
                                Dear <strong>{{ $inquiry->name }}</strong>{{ !empty($inquiry->company) ? " ({$inquiry->company})" : '' }},
                            </p>

                            <p style="font-size: 14.5px; line-height: 1.7; color: #334155; margin-top: 0; margin-bottom: 18px;">
                                Thank you for contacting <strong>{{ $siteSettings['company_name'] ?? 'PT Islenesia Agro Nusantara' }}</strong>. We have successfully received your inquiry regarding our Indonesian agricultural export commodities.
                            </p>

                            <p style="font-size: 14.5px; line-height: 1.7; color: #334155; margin-top: 0; margin-bottom: 24px;">
                                Our International Trade Desk and Quality Assurance department are currently reviewing your requested parameters. A dedicated export specialist will follow up with you directly within <strong>24 business hours</strong> with the requested information:
                            </p>

                            <!-- Process Steps -->
                            <div style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 20px; margin-bottom: 26px;">
                                <div style="font-size: 12px; font-weight: 800; color: #0B1B3D; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                                    Next Steps in Our Procurement Process:
                                </div>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13.5px; color: #475569; line-height: 1.6;">
                                    <tr>
                                        <td style="padding: 6px 0; width: 28px; vertical-align: top; color: #D4AF37; font-weight: bold;">01.</td>
                                        <td style="padding: 6px 0;"><strong>Technical Specification & COA:</strong> Verification of purity, moisture content, and crop season grading.</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; vertical-align: top; color: #D4AF37; font-weight: bold;">02.</td>
                                        <td style="padding: 6px 0;"><strong>Price Quotation (FOB / CIF):</strong> Customized commercial offer based on your target destination port and container volume.</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; vertical-align: top; color: #D4AF37; font-weight: bold;">03.</td>
                                        <td style="padding: 6px 0;"><strong>Sample Dispatch:</strong> Expedited air shipment of product samples for laboratory evaluation upon request.</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Inquiry Summary Table -->
                            <div style="margin-bottom: 28px;">
                                <div style="font-size: 13px; font-weight: 700; color: #0B1B3D; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Inquiry Summary for Your Records:
                                </div>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #E2E8F0; border-radius: 10px; overflow: hidden; font-size: 13.5px;">
                                    <tr style="background-color: #F8FAFC;">
                                        <td style="padding: 10px 14px; font-weight: 600; color: #64748B; width: 35%; border-bottom: 1px solid #E2E8F0;">Reference ID</td>
                                        <td style="padding: 10px 14px; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">#ISL-{{ $inquiry->id }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 14px; font-weight: 600; color: #64748B; border-bottom: 1px solid #E2E8F0;">Commodity / Product</td>
                                        <td style="padding: 10px 14px; font-weight: 700; color: #B45309; border-bottom: 1px solid #E2E8F0;">
                                            {{ $inquiry->product ? $inquiry->product->name : ($inquiry->subject ?: 'Agricultural Commodity Export') }}
                                        </td>
                                    </tr>
                                    <tr style="background-color: #F8FAFC;">
                                        <td style="padding: 10px 14px; font-weight: 600; color: #64748B; border-bottom: 1px solid #E2E8F0;">Inquiry Type</td>
                                        <td style="padding: 10px 14px; color: #0B1B3D; border-bottom: 1px solid #E2E8F0; text-transform: capitalize;">
                                            {{ $inquiry->type === 'pemasok' ? 'Supply Partner' : 'Commercial Buyer / Importer' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 14px; font-weight: 600; color: #64748B; border-bottom: 1px solid #E2E8F0;">Contact Information</td>
                                        <td style="padding: 10px 14px; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">
                                            {{ $inquiry->email ?: '-' }} {{ !empty($inquiry->whatsapp) && $inquiry->whatsapp !== '-' ? ' | ' . $inquiry->whatsapp : '' }}
                                        </td>
                                    </tr>
                                    <tr style="background-color: #F8FAFC;">
                                        <td style="padding: 10px 14px; font-weight: 600; color: #64748B; vertical-align: top;">Submitted Message</td>
                                        <td style="padding: 10px 14px; color: #334155; line-height: 1.5; font-size: 13px; white-space: pre-wrap;">{{ $inquiry->message }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Direct Response Prompt -->
                            <p style="font-size: 14px; line-height: 1.6; color: #475569; margin-bottom: 28px;">
                                If you have urgent questions, specific laboratory parameters, or wish to attach your purchase tender / RFQ documents, please feel free to reply directly to this email or contact our export desk:
                            </p>

                            <!-- Contact Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #0B1B3D; border-radius: 10px; color: #FFFFFF; font-size: 13px;">
                                <tr>
                                    <td style="padding: 18px 24px;">
                                        <div style="font-weight: 700; color: #D4AF37; margin-bottom: 6px; font-size: 14px;">
                                            Official International Export Desk
                                        </div>
                                        <div style="color: #CBD5E1; line-height: 1.6;">
                                            Email: <a href="mailto:{{ $siteSettings['email'] ?? 'info@islenesia.com' }}" style="color: #93C5FD; text-decoration: none;">{{ $siteSettings['email'] ?? 'info@islenesia.com' }}</a><br>
                                            Phone / WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number'] ?? '6285161313914') }}" style="color: #93C5FD; text-decoration: none;">{{ $siteSettings['phone'] ?? '+62 851-6131-3914' }}</a><br>
                                            Web: <a href="{{ url('/') }}" style="color: #93C5FD; text-decoration: none;">https://islenesia.com</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 30px; font-size: 14px; color: #475569; line-height: 1.6;">
                                Warm regards,<br>
                                <strong>International Trade & Export Team</strong><br>
                                <span>{{ $siteSettings['company_name'] ?? 'PT Islenesia Agro Nusantara' }}</span><br>
                                <span style="font-size: 12px; color: #94A3B8;">Indonesia • China • Europe Agricultural Supply Chain Network</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F1F5F9; border-top: 1px solid #E2E8F0; padding: 22px 36px; font-size: 11.5px; color: #64748B; text-align: center; line-height: 1.5;">
                            &copy; {{ date('Y') }} {{ $siteSettings['company_name'] ?? 'PT Islenesia Agro Nusantara' }}. All rights reserved.<br>
                            This is an automated confirmation sent to <strong>{{ $inquiry->email }}</strong> regarding your inquiry on <a href="{{ url('/') }}" style="color: #0B1B3D; text-decoration: none; font-weight: 600;">islenesia.com</a>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
