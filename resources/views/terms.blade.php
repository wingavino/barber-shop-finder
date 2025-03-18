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
        <h1>Terms and Conditions for Barbershop and Salon Finder System</h1>
        <p>These Terms and Conditions ("Agreement") govern your access to and use of S.A.B.E.R.</p>
        <p>By using the Service, you agree to comply with and be bound by these terms. If you do not agree to these terms, you must not use the Service.</p>
        
        <hr>
        
        <h2>1. Acceptance of Terms</h2>
        <p>By accessing or using S.A.B.E.R, you agree to be bound by these Terms and Conditions and any additional terms that apply to specific features or services of the platform. If you do not agree with these terms, please do not use the Service.</p>

        <hr>

        <h2>2. Changes to Terms</h2>
        <p>We reserve the right to modify, update, or change these Terms and Conditions at any time without prior notice. Any updates to these terms will be posted on this page with the date of revision. It is your responsibility to review these Terms regularly for any changes.</p>

        <hr>

        <h2>3. Eligibility</h2>
        <p>To use the Service, you must be at least 18 years old or the legal age in your jurisdiction to enter into a binding contract. By using the Service, you confirm that you meet these age requirements.</p>

        <hr>

        <h2>4. User Registration and Account</h2>
        <p>To access certain features of the Service, you may need to create an account. When registering, you agree to provide accurate, current, and complete information and to update it as necessary. You are responsible for maintaining the confidentiality of your login information and for all activities that occur under your account.</p>

        <hr>

        <h2>5. Service Description</h2>
        <p>The Service allows users to search for barbershops and salons, book appointments, and access information about businesses listed on the platform. The Service does not operate the barbershops or salons listed, nor does it guarantee the quality, safety, or accuracy of any services offered by the businesses.</p>

        <hr>

        <h2>6. User Conduct</h2>
        <p>You agree to use the Service in a lawful manner and to refrain from engaging in any of the following prohibited activities:</p>
        <ul>
            <li>Posting or transmitting any content that is illegal, offensive, harmful, or violates the rights of others.</li>
            <li>Attempting to interfere with the proper functioning of the Service or engaging in activities that could damage or disrupt the Service.</li>
            <li>Using the Service to impersonate others or misrepresent your identity.</li>
            <li>Engaging in spam, phishing, or other harmful activities.</li>
        </ul>

        <hr>

        <h2>7. Listings and Content</h2>
        <p>Barbershops and salons listed on the Service are responsible for the content they submit, including business descriptions, images, and pricing. While we strive to maintain accurate information, we do not guarantee the accuracy, completeness, or timeliness of such content.</p>
        <p>You agree not to hold S.A.B.E.R liable for any errors or omissions in the listings or services provided by businesses on the platform.</p>

        <hr>

        <h2>8. Booking and Payment</h2>
        <p>Bookings made through the Service are subject to the terms and policies of the individual barbershops and salons. Payment for services, cancellation policies, and other terms related to booking appointments should be discussed directly with the relevant business.</p>

        <hr>

        <h2>9. Privacy Policy</h2>
        <p>Your use of the Service is subject to our Privacy Policy. By agreeing to these Terms and Conditions, you acknowledge that you have read and understood our Privacy Policy, which explains how your personal data is collected, used, and protected.</p>

        <hr>
        
        <h2>10. Intellectual Property</h2>
        <p>All content, features, and functionality of the Service, including text, graphics, logos, images, and software, are the property of S.A.B.E.R and are protected by intellectual property laws. You may not use, reproduce, or distribute any part of the Service without our express written permission.</p>
        
        <hr>

        <h2>11. Limitation of Liability</h2>
        <p>To the fullest extent permitted by applicable law, S.A.B.E.R shall not be liable for any damages, including but not limited to direct, indirect, incidental, punitive, or consequential damages, arising from your use or inability to use the Service. This includes damages caused by reliance on information or content obtained through the Service.</p>

        <hr>

        <h2>12. Indemnity</h2>
        <p>You agree to indemnify, defend, and hold harmless S.A.B.E.R, its affiliates, and their respective officers, directors, employees, agents, and licensors from any claims, damages, losses, liabilities, and expenses (including legal fees) arising from your use of the Service, violation of these Terms, or infringement of any third-party rights.</p>

        <hr>

        <h2>13. Dispute Resolution and Governing Law</h2>
        <p>Any disputes arising from these Terms and Conditions will be governed by the laws of Cabanatuan City and will be resolved in the courts located within Cabanatuan City, Nueva Ecija, Philippines. You agree to submit to the personal jurisdiction of these courts.</p>

        <hr>

        <h2>14. Termination</h2>
        <p>We reserve the right to suspend or terminate your account and access to the Service at any time, for any reason, including if we believe you have violated these Terms.</p>

        <hr>

        <h2>15. Force Majeure</h2>
        <p>S.A.B.E.R shall not be held liable for any failure or delay in the performance of the Service due to events outside our reasonable control, including but not limited to acts of God, war, terrorism, or government regulations.</p>

        <hr>

        <h2>16. Severability</h2>
        <p>If any part of these Terms is found to be invalid or unenforceable, the remaining provisions shall remain in full force and effect.</p>

        <hr>

        <h2>17. Entire Agreement</h2>
        <p>These Terms and Conditions, together with our Privacy Policy, constitute the entire agreement between you and S.A.B.E.R regarding the use of the Service. If you have any questions about these Terms, please contact us at saber.shop.finder@gmail.com</p>

        <hr>

        <h2>18. Contact Information</h2>
        <p>For any inquiries or questions about these Terms and Conditions, please contact us at:</p>
        <p>Email: saber.shop.finder@gmail.com</p>

        <hr>

        <p>End of Terms and Conditions</p>


        </div>
    </div>
</div>
@endsection
