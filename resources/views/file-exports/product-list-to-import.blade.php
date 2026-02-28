<html>
    <table>
        <thead>
            <tr>
                <td>name</td>
                <td> category_id</td>
                <td> sub_category_id</td>
                <td>sub_sub_category_id</td>
                <td> brand_id</td>
                <td> unit</td>
                <td> minimum_order_qty</td>
                <td> status</td>
                <td> refundable</td>
                <td> youtube_video_url</td>
                <td> unit_price</td>
                <td> tax</td>
                <td> discount</td>
                <td> discount_type</td>
                <td> current_stock</td>
                <td> details</td>
                <td>thumbnail</td>
                <td>code</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['products'] as $key=>$item)
                <tr>
                    <td> {{$item->name}}</td>
                    <td>{{ $item->category_id ?? 0}}</td>
                    <td>{{ $item->sub_category_id ?? 0}}</td>
                    <td>{{ $item->sub_sub_category_id ?? 0}}</td>
                    <td>{{ $item->brand_id ?? 0}}</td>
                    <td>{{ $item->unit}}</td>
                    <td>{{$item->min_qty}}</td>
                    <td>{{$item->status}}</td>
                    <td>{{$item->refundable}}</td>
                    <td></td>
                    <td>{{$item->unit_price}}</td>
                    <td>{{$item->tax}}</td>
                    <td>{{$item->discount}}</td>
                    <td>{{$item->discount_type}}</td>
                    <td>{{$item->current_stock}}</td>
                    <td>{{$item->details}}</td>
                    <td></td>
                    <td>{{$item->code}}</td>
                </tr>
            @endforeach
       </tbody>
    </table>
</html>
