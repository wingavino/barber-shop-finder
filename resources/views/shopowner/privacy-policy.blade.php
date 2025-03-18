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
      <h1>Privacy Policy for S.A.B.E.R for Shop Owners</h1>
      <p>At S.A.B.E.R, we value the privacy of business owners who use our barbershop and salon finder. This Privacy Policy explains how we collect, use, store, and protect your business and personal information when you register your barbershop or salon with us.</p>
      <p>By accessing or using the Platform, you agree to the collection and use of your information as described in this policy. If you do not agree with the terms of this Privacy Policy, please do not use the Platform.</p>

      <hr>
            
      <h2>1. Information We Collect</h2>
      <p>We collect the following types of information from you as a business owner when you use our Platform:</p>
      <ol type="A">
        <li>
          Personal Information
          <ul>
            <li>
              Account Information: When you register your barbershop or salon on our Platform, we collect:
                <ul>
                  <li>Name</li>
                  <li>Email address</li>
                  <li>Phone number</li>
                  <li>Password</li>
                </ul>
            </li>
            <li>
              Payment Information: When subscribing to premium services or making payments, we may collect:
                <ul>
                  <li>Payment card details (processed by third-party payment processors)</li>
                  <li>Billing address</li>
                </ul>
            </li>
          </ul>
        </li>
        <li>
          Business Information
          <ul>
            <li>
              Business Profile: When you list your barbershop or salon, we collect:
              <ul>
                <li>Business name</li>
                <li>Contact details (email, phone number)</li>
                <li>Physical address</li>
                <li>Business description</li>
                <li>Services offered</li>
                <li>Pricing information</li>
                <li>Photos or media related to your business</li>
                <li>Business hours and availability</li>
                <li>Any licenses or certifications (where applicable)</li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          Non-Personal Information
          We may also collect non-personal information such as:
            <ul>
              <li>Device and browser information (IP address, browser type, operating system)</li>
              <li>Usage data (pages visited, clicks, time spent on the Platform)</li>
              <li>Location data (if your business listing includes location-based services)</li>
            </ul>
        </li>
        <li>
          Cookies and Tracking Technologies
          We use cookies to improve the user experience on the Platform. These cookies help us personalize content and analyze how you interact with our Platform. You can control the use of cookies through your browser settings.
        </li>
      </ol>

      <hr>
            
      <h2>2. How We Use Your Information</h2>
      <p>We use the information we collect for the following purposes:</p>
      <ul>
        <li>
          To Provide Platform Services:
            <ul>
              <li>To create and manage your business listing on the Platform</li>
              <li>To facilitate communication with users (customers) who book services at your business</li>
              <li>To process payments for premium services or commissions (if applicable)</li>
              <li>To display relevant ads or promotions based on your business</li>
            </ul>
        </li>
        <li>
          To Improve the Platform:
            <ul>
              <li>To analyze usage data and improve the Platform's functionality</li>
              <li>To personalize features and services for business owners</li>
              <li>To ensure the Platform’s security and technical functionality</li>
            </ul>
        </li>
        <li>
          To Communicate with You:
          <ul>
            <li>To send updates about your business listing or subscription status</li>
            <li>To notify you of new features or services on the Platform</li>
            <li>To send marketing communications related to our services (with your consent)</li>
          </ul>
        </li>
        <li>
          To Comply with Legal Obligations:
          <ul>
            <li>To ensure compliance with applicable laws and regulations</li>
            <li>To resolve disputes and protect our legal rights</li>
          </ul>
        </li>
      </ul>

      <hr>

      <h2>3. How We Share Your Information</h2>
      <p>We may share your personal and business information in the following ways:</p>
      <ul>
        <li>With Customers (Users): Your business information (such as business name, services, contact details, and availability) will be visible to customers searching for salons and barbershops through our Platform.</li>
        <li>With Service Providers: We may share your information with third-party service providers who help us operate the Platform, such as payment processors, hosting services, marketing platforms, and customer support providers. These third parties are contractually obligated to protect your information and use it only for the purposes we define.</li>
        <li>With Legal Authorities: We may disclose your information if required by law, such as in response to a subpoena or government inquiry, or to protect the rights, property, or safety of the Platform, users, or the public.</li>
        <li>With Your Consent: We may share your information with other third parties if you have provided explicit consent to do so (e.g., for promotional or partnership opportunities).</li>
      </ul>

      <hr>
            
      <h2>4. Data Retention</h2>
      <p>We retain your personal and business information for as long as your account is active or as needed to fulfill the purposes outlined in this Privacy Policy, such as maintaining business listings, processing payments, and complying with legal obligations.</p>
      <p>If you choose to delete your account or business listing, we will retain your information as required by law (for example, for tax or accounting purposes) but will remove your business profile from public view on the Platform.</p>

      <hr>

      <h2>5. Your Rights and Choices</h2>
      <p>As a business owner, you have certain rights regarding the information we collect from you:</p>
      <ul>
        <li>Access: You can request to view the personal and business information we hold about you.</li>
        <li>Correction: You can request to correct any inaccurate or outdated information in your account.</li>
        <li>Deletion: You can request to delete your personal and business information, subject to legal retention requirements.</li>
        <li>Opt-Out of Marketing: If you do not wish to receive marketing communications from us, you can opt-out by clicking the "unsubscribe" link in our emails or contacting us directly.</li>
        <li>Withdraw Consent: If you have previously provided consent for any data processing activities (such as marketing), you may withdraw your consent at any time.</li>
      </ul>
      <p>To exercise any of these rights, please contact us using the information provided in Section 8.</p>

      <hr>
            
      <h2>6. Data Security</h2>
      <p>We take the security of your personal and business information seriously and implement appropriate technical and organizational measures to protect it from unauthorized access, disclosure, or destruction. These measures include encryption, secure servers, and access control protocols.</p>
      <p>However, no system is completely secure, and we cannot guarantee the absolute security of your data.</p>

      <hr>
            
      <h2>7. Cookies and Tracking Technologies</h2>
      <p>We use cookies to improve your experience on the Platform and to analyze how business owners interact with our system. You can manage your cookie preferences through your browser settings, but please note that disabling cookies may impact your ability to use some features of the Platform.</p>
      <p>For more information, refer to our Cookie Policy.</p>

      <hr>

      <h2>8. Changes to This Privacy Policy</h2>
      <p>We may update this Privacy Policy from time to time. When significant changes are made, we will notify you through the Platform or via email. The updated Privacy Policy will be posted on this page with a new "Effective Date." We encourage you to periodically review this Privacy Policy to stay informed about how we are protecting your information.</p>

      <hr>

      <h2>9. Contact Us</h2>

      <p>If you have any questions, concerns, or requests regarding this Privacy Policy or the handling of your personal and business information, please contact us at:</p>
      <p>Email: saber.shop.finder@gmail.com</p>

      <hr>

      <p>End of Privacy Policy</p>
    </div>
  </div>
</div>
@endsection
