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
      <h1>Privacy Policy for S.A.B.E.R</h1>
      <p>At S.A.B.E.R, we are committed to protecting your privacy and ensuring a safe online experience. This Privacy Policy explains how we collect, use, store, and protect your personal data when you use our barbershop and salon finder system. By accessing or using the Platform, you agree to the terms of this Privacy Policy.</p>
      <p>If you do not agree with the terms of this Privacy Policy, please do not use the Platform.</p>

      <hr>

      <h2>1. Information We Collect</h2>
      <p>We collect two types of information from users:</p>
      <ol type="A">
        <li>
          Personal Information
          When you register on our Platform as a customer or a business owner, we may collect the following personal information:
            <ul>
              <li>
                For Customers:
                <ul>
                  <li>Name</li>
                  <li>Email address</li>
                  <li>Phone number</li>
                  <li>Appointment history</li>
                  <li>Location (if using location-based services)</li>
                </ul>
              </li>
            </ul>
        </li>
        
        <li>
          Non-Personal Information
          We may also collect non-personal information, including:
            <ul>
              <li>Device information (browser type, IP address, operating system)</li>
              <li>Usage data (pages visited, time spent, click behavior)</li>
              <li>Location data (with your consent, for location-based services)</li>
              <li>Cookies and tracking technologies for analytics</li>
            </ul>
        </li>
      </ol>

      <hr>

      <h2>2. How We Use Your Information</h2>
      <p>We use the information we collect for the following purposes:</p>
      <ul>
        <li>
          For Customers:
          <ul>
            <li>To provide personalized search results (e.g., barbershop and salon recommendations)</li>
            <li>To process appointment bookings and payments</li>
            <li>To communicate with you about your bookings, promotions, and updates</li>
            <li>To improve the functionality and user experience of the Platform</li>
            <li>To send marketing communications (only with your consent)</li>
          </ul>
        </li>

        <li>
          General Purposes:
          <ul>
            <li>To improve our services and the functionality of the Platform</li>
            <li>To comply with legal obligations and enforce our Terms and Conditions</li>
            <li>To protect the safety and security of users on the Platform</li>
          </ul>
        </li>
      </ul>

      <hr>

      <h2>3. How We Share Your Information</h2>
      <p>We do not sell your personal information to third parties. However, we may share your information in the following ways:</p>
      <ul>
        <li>With Service Providers: We may share your personal data with third-party service providers who assist us in operating the Platform, such as payment processors, hosting providers, and customer support services. These providers are obligated to keep your information secure and only use it for the services they provide.</li>
        <li>Legal Requirements: We may disclose your information if required to do so by law or in response to a valid legal request (e.g., to comply with a subpoena or regulatory inquiry).</li>
        <li>With Consent: We may share your information with other parties if you have given your consent to such sharing.</li>
      </ul>

      <hr>

      <h2>4. Data Retention</h2>
      <p>We will retain your personal information for as long as necessary to fulfill the purposes for which it was collected or as required by law. When we no longer need your personal information, we will securely delete or anonymize it.</p>

      <hr>

      <h2>5. Security of Your Information</h2>
      <p>We take the protection of your personal information seriously and use industry-standard security measures to safeguard it. These include:</p>
      <ul>
        <li>Encryption of sensitive data (e.g., payment information)</li>
        <li>Secure servers and networks</li>
        <li>Access control to ensure only authorized personnel can access personal data</li>
      </ul>
      <p>However, please note that no system is 100% secure, and we cannot guarantee the absolute security of your information.</p>

      <hr>

      <h2>6. Your Rights and Choices</h2>
      <p>Depending on your jurisdiction, you may have the following rights regarding your personal information:</p>
      <ul>
        <li>Access: You can request a copy of the personal information we hold about you.</li>
        <li>Correction: You can request that we correct any inaccurate or incomplete personal information.</li>
        <li>Deletion: You can request that we delete your personal information, subject to certain legal exceptions.</li>
        <li>Objection: You can object to the processing of your personal information in certain circumstances.</li>
        <li>Withdrawal of Consent: If you have provided consent for certain processing activities (e.g., marketing communications), you can withdraw that consent at any time.</li>
        <li>Data Portability: You can request a copy of your personal information in a format that can be transferred to another service provider.</li>
      </ul>
      <p>To exercise these rights, please contact us at: saber.shop.finder@gmail.com</p>

      <hr>

      <h2></h2>
      <p>We use cookies and other tracking technologies (such as web beacons) to improve your experience on the Platform. Cookies are small text files stored on your device that help us understand how you interact with the Platform. You can control cookie settings through your browser, but please note that disabling cookies may affect the functionality of the Platform.</p>

      <hr>

      <h2>8. Third-Party Links</h2>
      <p>Our Platform may contain links to third-party websites or services. These websites are not operated by us, and we are not responsible for their privacy practices or content. We encourage you to review the privacy policies of any third-party sites you visit.</p>

      <hr>

      <h2>9. Children’s Privacy</h2>
      <p>The Platform is not intended for use by children under the age of 13, and we do not knowingly collect personal information from children. If we become aware that we have collected personal information from a child under 13, we will take steps to delete that information.</p>

      <hr>

      <h2>10. Changes to This Privacy Policy</h2>
      <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated "Effective Date." We encourage you to review this Privacy Policy periodically to stay informed about how we are protecting your information.</p>

      <hr>

      <h2>11. Contact Us</h2>
      <p>If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at saber.shop.finder@gmail.com</p>

      <hr>

      <p>End of Privacy Policy</p>
    </div>
  </div>
</div>
@endsection
