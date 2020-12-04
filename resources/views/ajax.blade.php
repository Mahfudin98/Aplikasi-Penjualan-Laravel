<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <form action="">
        <div class="col-md-12 form-group p_star">
            <label for="">Propinsi</label>
            <select class="form-control" id="province_id" name="province_id" required>
                <option value="">Pilih Propinsi</option>
                @foreach ($provinces as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
            <p class="text-danger">{{ $errors->first('province_id') }}</p>
        </div>
        <div class="col-md-12 form-group p_star">
            <label for="">Kabupaten / Kota</label>
            <select class="form-control" name="city_id" id="city_id" required>
                <option value="">Pilih Kabupaten/Kota</option>
            </select>
            <p class="text-danger">{{ $errors->first('city_id') }}</p>
        </div>
        <div class="col-md-12 form-group p_star">
            <label for="">Kecamatan</label>
            <select class="form-control" name="district_id" id="district_id" required>
                <option value="">Pilih Kecamatan</option>
            </select>
            <p class="text-danger">{{ $errors->first('district_id') }}</p>
        </div>
    </form>

    <script type="text/javascript">
        $('#province_id').on('change', function() {
            $.ajax({
                url: "{{ url('/api/city') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){

                    $('#city_id').empty()
                    $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_id').append('<option value="'+item.id+'">'+item.name+'</option>')
                    })
                }
            });
        })

        $('#city_id').on('change', function() {
            $.ajax({
                url: "{{ url('/api/district') }}",
                type: "GET",
                data: { city_id: $(this).val() },
                success: function(html){
                    $('#district_id').empty()
                    $('#district_id').append('<option value="">Pilih Kecamatan</option>')
                    $.each(html.data, function(key, item) {
                        $('#district_id').append('<option value="'+key.id+'">'+item.name+'</option>')
                    })
                }
            });
        })
    </script>
</body>
</html>
