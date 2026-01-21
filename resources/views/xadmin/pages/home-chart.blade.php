@extends('xadmin.layouts.default')
@section('content')
    @php
        $tdClass = 'p-2 border border-gray-300';
    @endphp


    <!-- Content -->
    <div class="container-fluid mx-auto">
        <h2 class="text-xl font-bold mb-4">Dashboard</h2>
        <div class="flex flex-wrap w-full">


            <div class="flex flex-wrap w-full mb-6">
                <div class="w-full md:w-1/4 p-4">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold">Ortalama Ziyaretçi Sayısı</h3>
                        <p class="text-xl font-bold">{{ round($averageVisits, 2) }}</p>
                    </div>
                </div>
                <div class="w-full md:w-1/4 p-4">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold">En Çok Ziyaret Edilen Sayfa</h3>
                        <p class="text-sm">{{ $mostVisitedPage ?? 'Veri bulunamadı' }}</p>
                    </div>
                </div>

                <div class="w-full md:w-1/4 p-4">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold">En Popüler Referans Kaynağı</h3>
                        <p class="text-sm">{{ $refererSource->referer ?? 'Veri bulunamadı' }}  <span class="text-gray-600 text-sm block w-full">{{ $refererCount }} kez ziyaret edildi.</span> </p>
                    </div>
                </div>
                <div class="w-full md:w-1/4 p-4">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold">Toplam Ziyaretçi Sayısı</h3>
                        <p class="text-xl font-bold">{{ $refererCount }}</p>
                    </div>
                </div>




            </div>
            <div class="flex flex-wrap w-full bg-white rounded-md p-3 mb-6">


              <h3 class="font-bold mb-3">Ziyaretçi Verileri</h3>

                <table class="table-auto w-full border-collapse  border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">IP Adresi</th>
                            <th class="border border-gray-300 px-4 py-2">Tarayıcı</th>
                            <th class="border border-gray-300 px-4 py-2">Ülke</th>
                            <th class="border border-gray-300 px-4 py-2">Cihaz</th>
                            <th class="border border-gray-300 px-4 py-2">Ziyaret Sayısı</th>
                            <th class="border border-gray-300 px-4 py-2">Son Ziyaret</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitors as $visitor)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $visitor->ip_address }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $visitor->browser == 'Unknown' ? $visitor->browser . ' (Google Bot)' : $visitor->browser }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $visitor->country }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $visitor->device }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $visitor->visit_count }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $visitor->last_visit_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Ziyaretçi
                                    bulunamadı.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex justify-center items-center w-full">
                  {{ $visitors->links('vendor.pagination.bootstrap') }}
                </div>

            </div>
  


        </div>
    @endsection
<!-- 
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush -->
