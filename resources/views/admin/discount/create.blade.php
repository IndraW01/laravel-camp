<x-app-layout>
    <section class="dashboard" style="margin-top: 100px">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        Management Discount
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            Insert a new Discount
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.discount.store') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" required value="{{ old('name') }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="code" class="form-label">Code</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" required value="{{ old('code') }}">
                                        @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-9">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description"
                                            rows="2">{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="percentage" class="form-label">Discount Percentage</label>
                                        <input type="number"
                                            class="form-control @error('percentage') is-invalid @enderror"
                                            id="percentage" name="percentage" min="1" max="100" required
                                            value="{{ old('percentage') }}">
                                        @error('percentage')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
