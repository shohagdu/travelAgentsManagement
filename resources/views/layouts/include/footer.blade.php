<footer class="footer text-center">
  @php  $setup_data =  App\Models\OrganizationSetup::first(); @endphp
    All Rights Reserved by {{ !empty($setup_data->name) ? $setup_data->name : ''}}. Designed and Developed by
    <a href="https://www.abc.com"> Abc Ltd </a>.
  </footer>