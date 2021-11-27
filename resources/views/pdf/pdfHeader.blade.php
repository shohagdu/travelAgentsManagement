<table class="width-100 " >
    <tr>
        <td class="text-center-invoice">
            <img src="{{ asset('public/assets/images')}}/{{$organization_info->logo}}" style="height: 50px"/>
            <div class="invoiceCompanyAddress">
                <span>{{$organization_info->address}}</span>,
                <br/>
                www.tripayan.com, <span>{{(!empty($organization_info->mobile)?$organization_info->mobile:'')}}</span>,<span> {{$organization_info->email}}</span>
            </div>
        </td>
    </tr>
</table>
