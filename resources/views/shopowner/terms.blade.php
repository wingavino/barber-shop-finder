@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Script to initialize map and Retrieve list of shops -->
<script type="text/javascript" async>
  var app_url = "{{env('APP_URL')}}";
</script>

<script defer type="text/javascript" src="{{ asset('js/maps/map.js') }}"></script>

<script defer type="text/javascript" src="{{ asset('js/maps/search.js') }}"></script>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap"></script>

<script type="text/javascript" src="{{ asset('js/requestAlert.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1>Terms and Conditions for Barbershop and Salon Owners</h1>
            <p>These Terms and Conditions ("Agreement") govern the registration, listing, and usage of the S.A.B.E.R by barbershop and salon owners ("Business Owners" or "You"). By registering or using the Platform, you agree to comply with and be bound by these Terms and Conditions. If you do not agree with these terms, you may not use the Platform.</p>

            <hr>

            <h2>1. Acceptance of Terms</h2>
            <p>By using the Platform, Business Owners agree to these Terms and Conditions. If you are using the Platform on behalf of a company, you confirm that you have the authority to bind the company to these Terms.</p>

            <hr>
            
            <h2>2. Account Registration</h2>
            <p>To list your barbershop or salon on the Platform, you must create an account. When registering, you agree to:</p>
            <ul>
                <li>Provide accurate, current, and complete information, including the name of your business, contact details, services, business hours, and pricing.</li>
                <li>Keep your information up-to-date and notify the Platform of any changes.</li>
                <li>Protect your account login information and notify the Platform immediately in case of unauthorized access.</li>
            </ul>

            <hr>
            
            <h2>3. Listing and Content</h2>
            <p>You are responsible for all content you submit to the Platform, including business descriptions, images, and pricing. By submitting content:</p>
            <ul>
                <li>You grant the Platform a worldwide, royalty-free, non-exclusive license to use, display, and distribute your business's content on the Platform and in marketing materials.</li>
                <li>You represent and warrant that you own or have the necessary rights to the content submitted and that it does not infringe on the intellectual property rights of others.</li>
                <li>You must ensure that your content complies with applicable laws, is not offensive, misleading, or false, and does not violate third-party rights.</li>
            </ul>
            <p>The Platform reserves the right to remove or modify any listings that violate these terms.</p>

            <hr>
            
            <h2>4. Service Booking</h2>
            <p>The Platform provides users with the ability to book appointments at your business. Business Owners agree to:</p>
            <ul>
                <li>Honor all bookings made through the Platform and provide the services as described in your listing.</li>
                <li>Communicate any changes to your availability promptly through the Platform.</li>
                <li>Set your cancellation and refund policies, and ensure that they are clearly stated on your listing page.</li>
            </ul>

            <hr>
            
            <h2>5. Fees and Payment</h2>
            <ul>
                <li>Subscription Fees: Saber may charge a subscription or listing fee for being listed on the Platform. These fees will be communicated to you during registration and may vary based on the subscription plan you select.</li>
                <li>Commission Fees: If applicable, Saber may charge a commission for each booking made through the Platform. The commission percentage will be outlined in your account settings or in a separate agreement.</li>
                <li>Payments: Payments for services booked through the Platform are processed through a third-party payment processor. You agree to comply with the payment terms of that processor.</li>
            </ul>
            <p>All fees are non-refundable unless specified otherwise in the platform's cancellation policy.</p>

            <hr>
            
            <h2>6. Privacy and Data Protection</h2>
            <p>By using the Platform, you agree to comply with all applicable data protection laws regarding customer data. You are responsible for securing and using the personal data of customers in accordance with privacy laws (e.g., GDPR, CCPA). You agree not to sell, distribute, or misuse customer data.</p>

            <hr>
            
            <h2>7. User Reviews and Feedback</h2>
            <p>Customers may leave reviews and ratings for your business. You agree to:</p>
            <ul>
                <li>Use the reviews constructively and address customer feedback.</li>
                <li>Not manipulate or solicit reviews in violation of Platform guidelines or applicable laws.</li>
                <li>Respond to any customer disputes, complaints, or issues promptly.</li>
            </ul>
            <p>The Platform reserves the right to moderate, remove, or display reviews at its discretion.</p>

            <hr>
            
            <h2>8. Responsibilities and Compliance</h2>
            <p>As a business owner, you agree to:</p>
            <ul>
                <li>Comply with all applicable laws and regulations, including licensing, health, safety, and labor laws.</li>
                <li>Maintain appropriate insurance coverage, including liability insurance, if required by law.</li>
                <li>Be responsible for the quality of services provided at your business, and for any issues arising from the services provided.</li>
                <li>Ensure that your business meets the safety, hygiene, and other legal standards for operating a barbershop or salon.</li>
            </ul>

            <hr>
            
            <h2>9. Termination of Agreement</h2>
            <p>S.A.B.E.R reserves the right to suspend or terminate your account if:</p>
            <ul>
                <li>You violate any of these Terms and Conditions.</li>
                <li>You fail to provide accurate or up-to-date information.</li>
                <li>You fail to comply with any applicable laws or Platform guidelines.</li>
            </ul>
            <p>Upon termination, you will no longer have access to your listing or any of the Platform's services. Termination will not affect any outstanding obligations, including any outstanding fees.</p>

            <hr>
            
            <h2>10. Limitation of Liability</h2>
            <p>To the fullest extent permitted by applicable law, [Your Platform Name] shall not be liable for any direct, indirect, incidental, consequential, or punitive damages arising from the use of the Platform, including but not limited to errors in your business listings, technical issues, or failure of services provided by your business.</p>

            <hr>
            
            <h2>11. Indemnity</h2>
            <p>You agree to indemnify and hold harmless, its affiliates, and their employees, officers, directors, and agents from any claims, losses, liabilities, damages, and expenses (including legal fees) arising from your violation of these Terms and Conditions, your business's actions, or any claim related to your services.</p>

            <hr>
            
            <h2>12. Intellectual Property</h2>
            <p>You retain ownership of the intellectual property rights to your business name, logo, and other content you provide. However, by submitting content to the Platform, you grant S.A.B.E.R a license to use, modify, distribute, and display that content in connection with providing the services and marketing the Platform.</p>

            <hr>
            
            <h2>13. Dispute Resolution and Governing Law</h2>
            <p>Any disputes related to this Agreement will be governed by the laws of Cabanatuan City. You agree that any disputes will be resolved through binding arbitration in Cabanatuan City, Nueva Ecija, rather than in court.</p>

            <hr>
            
            <h2>14. Force Majeure</h2>
            <p>Neither party shall be held liable for any failure or delay in performance due to circumstances beyond their reasonable control, including but not limited to natural disasters, acts of government, or technical failures.</p>

            <hr>
            
            <h2>15. Amendments to Terms</h2>
            <p>S.A.B.E.R reserves the right to modify these Terms and Conditions at any time. You will be notified of any material changes. By continuing to use the Platform after changes are posted, you accept those changes.</p>

            <hr>
            
            <h2>16. Contact Information</h2>
            <p>If you have any questions about these Terms and Conditions, or need support with your listing or account, please contact us at saber.shop.finder@gmail.com</p>


            <hr>
            
            <p>End of Terms and Conditions</p>

        </div>
    </div>
</div>
@endsection
