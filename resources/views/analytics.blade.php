<x-header :currPage="8" :userLogged=$userLogged></x-header>
<div class="app-content content" style="overflow: scroll;">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body" ><!-- Chart -->
            <div class="row match-height" style="justify-content: space-between; flex-direction: column">
                <h2 class="mt-3">Analytics</h2>
                <canvas id="myChart" width="400" height="400"></canvas>
            </div></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [@foreach($chartUserLogin["loginTypes"] as $loginType) "{{$loginType->user_agent}}", @endforeach],
            datasets: [{
                label: 'Ulogovani korisnici po tipu browsera',
                data: [@foreach($chartUserLogin["loginCount"] as $loginType) {{$loginType->userAgent}}, @endforeach],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });



</script>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<x-footer></x-footer>
