<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konverter Mata Uang</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .currency-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            padding: 1.5rem;
        }
        .result-box {
            padding: 15px;
            background-color: #e9f7ef;
            border-radius: 5px;
            border: 1px solid #d5e8d4;
            margin-top: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="currency-card bg-white">
                    <div class="card-header text-center">
                        <h1 class="display-6 fw-bold mb-0">Kurs Mata Uang</h1>
                        <p class="text-light mt-2">Konversi mata uang dari seluruh dunia dengan mudah</p>
                    </div>

                    <div class="card-body p-4">
                        <form id="converterForm" action="{{ route('currency.convert') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- Mata Uang 1 -->
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded h-100">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0.01" value="{{ $amount ?? 1 }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="from_currency" class="form-label">Dari Mata Uang</label>
                                            <select class="form-select" id="from_currency" name="from_currency" required>
                                                @isset($currencies)
                                                    @foreach($currencies as $code => $name)
                                                        <option value="{{ $code }}" {{ isset($fromCurrency) && $fromCurrency == $code ? 'selected' : ($code == 'USD' && !isset($fromCurrency) ? 'selected' : '') }}>
                                                            {{ $code }} - {{ $name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mata Uang 2 -->
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded h-100">
                                        <div id="result-container" class="mb-3 d-none">
                                            <label class="form-label">Hasil Konversi</label>
                                            <div class="form-control bg-white" id="result-display"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="to_currency" class="form-label">Ke Mata Uang</label>
                                            <select class="form-select" id="to_currency" name="to_currency" required>
                                                @isset($currencies)
                                                    @foreach($currencies as $code => $name)
                                                        <option value="{{ $code }}" {{ isset($toCurrency) && $toCurrency == $code ? 'selected' : ($code == 'IDR' && !isset($toCurrency) ? 'selected' : '') }}>
                                                            {{ $code }} - {{ $name }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(isset($convertedAmount))
                            <div class="result-box text-center mt-4">
                                {{ $amount }} {{ $fromCurrency }} = {{ $convertedAmount }} {{ $toCurrency }}
                            </div>
                            @endif

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5" id="convert-btn">
                                    <span id="btn-text">Konversi</span>
                                    <span id="btn-loading" class="d-none">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Mengkonversi...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer bg-light py-3">
                        <p class="text-muted text-center mb-0 small">
                            Data kurs diambil dari OpenExchangeRates
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#converterForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const formData = new FormData(this);

                // Show loading state
                $('#btn-text').addClass('d-none');
                $('#btn-loading').removeClass('d-none');
                $('#convert-btn').prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        const resultText = `${response.amount} ${response.from} = ${response.result} ${response.to}`;
                        $('#result-display').text(resultText);
                        $('#result-container').removeClass('d-none');

                        // Reset loading state
                        $('#btn-text').removeClass('d-none');
                        $('#btn-loading').addClass('d-none');
                        $('#convert-btn').prop('disabled', false);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat melakukan konversi mata uang.');

                        // Reset loading state
                        $('#btn-text').removeClass('d-none');
                        $('#btn-loading').addClass('d-none');
                        $('#convert-btn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>
