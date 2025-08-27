@extends('layouts.app')

@section('page-title')
    {{ __('Product Prices') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Product Prices') }}</li>
@endsection

@section('card-action-btn')
    <form action="{{ route('prices.productprices.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
        @csrf
        <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
        <button type="submit" class="btn btn-sm btn-primary">
            <i data-feather="upload"></i> Import Files
        </button>
    </form>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Product Prices') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="dataTable">
                        <thead>
                <tr>
    <th>Product Id</th>
    <th>Schema ID</th>
    <th>Product Code</th>
    <th>Product Class</th>
    <th>Description</th>
    <th>Retrofit</th>
    <th>Nailon</th>
    <th>Block</th>
    <th>Clr</th>
    <th>Le3</th>
    <th>Le3 Clr</th>
    <th>Clr Clr</th>
    <th>Le3 Lam</th>
    <th>Le3 Clr Le3</th>
    <th>Clr Temp</th>
    <th>1Le3 1Clrtemp</th>
    <th>2Le3 1Clrtemp</th>
    <th>Lam Temp</th>
    <th>Clt Clt</th>
    <th>Let Let Let</th>
    <th>Le3 Lam Le3</th>
    <th>Let Clt Let</th>
    <th>Let Lam Let</th>
    <th>Let Clt</th>
    <th>Obs</th>
    <th>Gery</th>
    <th>Rain</th>
    <th>Temp</th>
    <th>Clr Lam</th>
    <th>Color Multi</th>
    <th>Base Multi</th>
    <th>Feat1</th>
    <th>Feat2</th>
    <th>Feat3</th>
    <th>Sta Grid</th>
    <th>Tpi</th>
    <th>Tpo</th>
    <th>Acid Etch</th>
    <th>Acid Edge</th>
    <th>Solar Cool</th>
    <th>Solar Cool G</th>
    <th>Sales Factor</th>
    <th>Total Cost</th>
    <th>Cost Ft</th>
    <th>Cost Pc</th>
    <th>Cost</th>
    <th>Mark Up</th>
    <th>Rate</th>
    <th>M Cost</th>
    <th>Calculated Cost</th>
    <th>Cost Inch</th>
    <th>Unit Box</th>
    <th>Price Box</th>
    <th>Price Piece</th>
    <th>Box Weight</th>
    <th>Ft Box</th>
    <th>Inch Box</th>
    <th>Price Inch</th>
    <th>Vent</th>
    <th>Xfix</th>
    <th>Fix</th>
    <th>Grid</th>
    <th>Lam Im Gx</th>
    <th>Two Panel Frame</th>
    <th>Three Panel Frame</th>
    <th>Four Panel Frame</th>
    <th>Panel</th>
    <th>Price Sq Ft</th>
    <th>Stf</th>
    <th>Labor Sta</th>
    <th>Labor Field</th>
    <th>Profit</th>
    <th>Purchase Price</th>
    <th>Markup Percentage</th>
    <th>Purchase By Piece</th>
    <th>Purchase By Bnd 99</th>
    <th>Purchase By Bnd 54</th>
    <th>Purchase By Bnd 70</th>
    <th>Purchase By Bnd 63</th>
    <th>Purchase By Bnd 77</th>
    <th>Purchase By Bnd 49</th>
    <th>Purchase By Bnd 42</th>
    <th>Purchase By Bnd 396</th>
    <th>Purchase By Bnd 510</th>
    <th>Purchase By Bnd 341</th>
    <th>Purchase By Bnd 81</th>
    <th>Purchase By Bnd 72</th>
    <th>Purchase By Bnd 90</th>
</tr></thead>
            <tbody>
@foreach($prices as $item)
    <tr>
        <td>{{ $item->product_id }}</td>    
    <td>{{ $item->schema_id }}</td>
    <td>{{ $item->product_code }}</td>
    <td>{{ $item->product_class }}</td>
    <td>{{ $item->description }}</td>
    <td>{{ $item->retrofit }}</td>
    <td>{{ $item->nailon }}</td>
    <td>{{ $item->block }}</td>
    <td>{{ $item->clr }}</td>
    <td>{{ $item->le3 }}</td>
    <td>{{ $item->le3_clr }}</td>
    <td>{{ $item->clr_clr }}</td>
    <td>{{ $item->le3_lam }}</td>
    <td>{{ $item->le3_clr_le3 }}</td>
    <td>{{ $item->clr_temp }}</td>
    <td>{{ $item->onele3_1clrtemp }}</td>
    <td>{{ $item->twole3_1clrtemp }}</td>
    <td>{{ $item->lam_temp }}</td>
    <td>{{ $item->clt_clt }}</td>
    <td>{{ $item->let_let_let }}</td>
    <td>{{ $item->le3_lam_le3 }}</td>
    <td>{{ $item->let_clt_let }}</td>
    <td>{{ $item->let_lam_let }}</td>
    <td>{{ $item->let_clt }}</td>
    <td>{{ $item->obs }}</td>
    <td>{{ $item->gery }}</td>
    <td>{{ $item->rain }}</td>
    <td>{{ $item->temp }}</td>
    <td>{{ $item->clr_lam }}</td>
    <td>{{ $item->color_multi }}</td>
    <td>{{ $item->base_multi }}</td>
    <td>{{ $item->feat1 }}</td>
    <td>{{ $item->feat2 }}</td>
    <td>{{ $item->feat3 }}</td>
    <td>{{ $item->sta_grid }}</td>
    <td>{{ $item->tpi }}</td>
    <td>{{ $item->tpo }}</td>
    <td>{{ $item->acid_etch }}</td>
    <td>{{ $item->acid_edge }}</td>
    <td>{{ $item->solar_cool }}</td>
    <td>{{ $item->solar_cool_g }}</td>
    <td>{{ $item->sales_factor }}</td>
    <td>{{ $item->total_cost }}</td>
    <td>{{ $item->cost_ft }}</td>
    <td>{{ $item->cost_pc }}</td>
    <td>{{ $item->cost }}</td>
    <td>{{ $item->mark_up }}</td>
    <td>{{ $item->rate }}</td>
    <td>{{ $item->m_cost }}</td>
    <td>{{ $item->calculated_cost }}</td>
    <td>{{ $item->cost_inch }}</td>
    <td>{{ $item->unit_box }}</td>
    <td>{{ $item->price_box }}</td>
    <td>{{ $item->price_piece }}</td>
    <td>{{ $item->box_weight }}</td>
    <td>{{ $item->ft_box }}</td>
    <td>{{ $item->inch_box }}</td>
    <td>{{ $item->price_inch }}</td>
    <td>{{ $item->vent }}</td>
    <td>{{ $item->xfix }}</td>
    <td>{{ $item->fix }}</td>
    <td>{{ $item->grid }}</td>
    <td>{{ $item->lam_im_gx }}</td>
    <td>{{ $item->two_panel_frame }}</td>
    <td>{{ $item->three_panel_frame }}</td>
    <td>{{ $item->four_panel_frame }}</td>
    <td>{{ $item->panel }}</td>
    <td>{{ $item->price_sq_ft }}</td>
    <td>{{ $item->stf }}</td>
    <td>{{ $item->labor_sta }}</td>
    <td>{{ $item->labor_field }}</td>
    <td>{{ $item->profit }}</td>
    <td>{{ $item->purchase_price }}</td>
    <td>{{ $item->markup_percentage }}</td>
    <td>{{ $item->purchase_by_piece }}</td>
    <td>{{ $item->purchase_by_bnd_99 }}</td>
    <td>{{ $item->purchase_by_bnd_54 }}</td>
    <td>{{ $item->purchase_by_bnd_70 }}</td>
    <td>{{ $item->purchase_by_bnd_63 }}</td>
    <td>{{ $item->purchase_by_bnd_77 }}</td>
    <td>{{ $item->purchase_by_bnd_49 }}</td>
    <td>{{ $item->purchase_by_bnd_42 }}</td>
    <td>{{ $item->purchase_by_bnd_396 }}</td>
    <td>{{ $item->purchase_by_bnd_510 }}</td>
    <td>{{ $item->purchase_by_bnd_341 }}</td>
    <td>{{ $item->purchase_by_bnd_81 }}</td>
    <td>{{ $item->purchase_by_bnd_72 }}</td>
    <td>{{ $item->purchase_by_bnd_90 }}</td>
</tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection