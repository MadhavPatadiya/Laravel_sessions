<!DOCTYPE html>
<html>

<head>
    <title>Customer Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="form-heading">Customer Form</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('add.to.session') }}" method="POST" oninput="calculateTotal()">
            @csrf
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <label for="customer" class="form-label">Customer</label>
                <input type="text" class="form-control" id="customer" name="customer" required>
            </div>
            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <select class="form-select" id="selectproduct" name="product" required>
                    <option value="">Select a product...</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->Product_Name }}" data-rate="{{ $product->Rate }}"
                            data-unit="{{ $product->Unit }}">
                            {{ $product->Product_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rate" class="form-label">Rate</label>
                <input type="number" step="0.01" class="form-control" id="Rate" name="Rate">
            </div>

            <div class="mb-3">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" class="form-control" id="Unit" name="Unit">
            </div>

            <div class="mb-3">
                <label for="qty" class="form-label">Quantity</label>
                <input type="number" step="0.01" class="form-control" id="qty" name="qty" required>
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" step="0.01" class="form-control" id="discount" name="discount">
            </div>
            <div class="mb-3">
                <label for="net_amount" class="form-label">Net Amount</label>
                <input type="number" step="0.01" class="form-control" id="net_amount" name="net_amount">
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Amount</label>
                <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount">
            </div>
            <button type="submit" class="btn btn-primary" onclick="showPopup()">+ADD</button>
        </form>
    </div>

    <!-- Modal Code -->
    <div class="modal fade bd-example-modal-lg" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupModalLabel">Form Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Rate</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Disc. (%)</th>
                                <th>Net Amt.</th>
                                <th>Total Amt.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session()->has('form_data'))
                                @foreach (session('form_data') as $index => $data)
                                    <tr>
                                        <td>{{ $data['customer'] }}</td>
                                        <td>{{ $data['product'] }}</td>
                                        <td>{{ $data['Rate'] }}</td>
                                        <td>{{ $data['Unit'] }}</td>
                                        <td>{{ $data['qty'] }}</td>
                                        <td>{{ $data['discount'] }}</td>
                                        <td>{{ $data['net_amount'] }}</td>
                                        <td>{{ $data['total_amount'] }}</td>
                                        <td>
                                            <form action="{{ route('remove.session.data', $index) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('submit.session.data') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectProduct = document.getElementById('selectproduct');
            const rateField = document.getElementById('Rate');
            const unitField = document.getElementById('Unit');

            selectProduct.addEventListener('change', function() {

                const selectedOption = selectProduct.options[selectProduct.selectedIndex];

                const rate = selectedOption.getAttribute('data-rate');
                const unit = selectedOption.getAttribute('data-unit');

                rateField.value = rate;
                unitField.value = unit;

                calculateTotal();
            });
        });

        function calculateTotal() {

            var rate = parseFloat(document.getElementById('Rate').value);
            var qty = parseFloat(document.getElementById('qty').value);
            var discountPercent = parseFloat(document.getElementById('discount').value);

            var discountAmount = 0;
            if (discountPercent > 0) {
                discountAmount = (rate * discountPercent) / 100;
            }

            var netAmount = rate - discountAmount;
            document.getElementById('net_amount').value = netAmount.toFixed(2);

            var totalAmount;
            if (discountPercent > 0) {
                totalAmount = netAmount * qty;
            } else {
                totalAmount = rate * qty;
            }
            document.getElementById('total_amount').value = totalAmount.toFixed(2);
        }

        function showPopup() {
            var popupModal = new bootstrap.Modal(document.getElementById('popupModal'));
            popupModal.show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>

</html>
