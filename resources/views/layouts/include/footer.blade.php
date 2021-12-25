<footer class="footer" style="text-align: right"   >
    @php  $setup_data =  App\Models\OrganizationSetup::first(); @endphp
    All Rights Reserved by {{ !empty($setup_data->name) ? $setup_data->name : ''}}. Designed and Developed by
    <a href="https://www.steptechbd.com" target="_blank"> Step Technology </a>.
</footer>
