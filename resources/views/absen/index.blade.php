@extends('layouts.master')
@section('title','User')
@section('css')
 <link href="https://unpkg.com/tabulator-tables@5.5.0/dist/css/tabulator.min.css" rel="stylesheet">   
@endsection
@section('content')

        <div class="page-content-wrapper py-3">
            @include('include.admin.alert')
			<!-- Pagination-->
			<div class="shop-pagination pb-3">
				<div class="container">
					
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('absen.create') }}" class="btn btn-primary">Absen</a>
                        
                    </div>
                            
						
				</div>
			</div>

            

           

            

			<div class="top-products-area product-list-wrap">
				<div class="container">
					<div class="row g-3">
                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <h4 style="text-align: center">{{ auth()->user()->nama_lengkap }}</h4>
                                    <div class="mb-3">
                                        <label for="month-filter" class="form-label" style="color: black">Pilih Bulan:</label>
                                        <input type="month" id="month-filter" class="form-control">
                                    </div>
                                    <div id="example-table" class="mt-3"></div>
                                   
                                </div>
                            </div>
                        </div>
						
					</div>
				</div>
			</div>


			

		</div>
@section('js')
<script src="https://unpkg.com/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Set bulan default ke bulan saat ini
    const currentMonth = new Date().toISOString().slice(0, 7);
    document.getElementById('month-filter').value = currentMonth;
    
    const table = new Tabulator("#example-table", {
        ajaxURL: `/absensi?bulan=${currentMonth}`,
        layout: "fitColumns",
        responsiveLayout: "collapse",
        pagination: "local",
        paginationSize: 10,
        paginationSizeSelector: [10, 20, 31, 50],
        initialSort: [{column: "tanggal_raw", dir: "desc"}],
        columns: [
            {title: "Tanggal", field: "tanggal", sorter: "date", hozAlign: "left", 
             formatter: function(cell) {
                 const data = cell.getRow().getData();
                 return data.is_today ? `<strong>${cell.getValue()} (Hari Ini)</strong>` : cell.getValue();
             }},
            {title: "Masuk", field: "masuk", hozAlign: "center"},
            {title: "Pulang", field: "pulang", hozAlign: "center"},
        ],
        rowFormatter: function(row) {
            const data = row.getData();
            
            // Highlight hari ini
            if(data.is_today) {
                row.getElement().style.backgroundColor = "#e6f7ff";
                row.getElement().style.fontWeight = "bold";
            }
            
            // Warna baris berdasarkan status absen
            if(data._rowColor) {
                row.getElement().style.backgroundColor = data._rowColor;
            }
        },
    });

    // Filter bulan
   document.getElementById("month-filter").addEventListener("change", function(e) {
    const bulan = e.target.value;
        if (!bulan) return;
        
        table.setData(`/absensi?bulan=${bulan}`).then(function() {
            const today = new Date();
            if (bulan === today.toISOString().slice(0, 7)) {
                const currentDay = today.getDate();
                const pageSize = table.getPageSize();
                const page = Math.ceil(currentDay / pageSize);
                table.setPage(page);
            } else {
                table.setPage(1); // Kembali ke halaman 1 untuk bulan lain
            }
        }).catch(function(error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat memuat data");
        });
    });
});
</script>
@endsection  

@endsection