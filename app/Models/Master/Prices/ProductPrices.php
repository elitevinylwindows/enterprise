<?php

namespace App\Models\Master\Prices;

use Illuminate\Database\Eloquent\Model;

class ProductPrices extends Model
{
    protected $table = 'elitevw_master_prices_product_prices'; 
    protected $guarded = [];

    protected $fillable = [
        'product_id', 'schema_id', 'product_code', 'product_class', 'description', 'retrofit', 'nailon', 'block', 'clr', 'le3',
        'le3_clr', 'clr_clr', 'le3_lam', 'le3_clr_le3', 'clr_temp', 'onele3_1clrtemp', 'twole3_1clrtemp', 'lam_temp',
        'clt_clt', 'let_let_let', 'let_clt_let', 'let_lam_let', 'let_clt', 'obs', 'gery', 'rain', 'temp', 'clr_lam',
        'color_multi', 'base_multi', 'feat1', 'feat2', 'feat3', 'sta_grid', 'tpi', 'tpo', 'acid_etch', 'acid_edge',
        'solar_cool', 'solar_cool_g', 'sales_factor', 'total_cost', 'cost_ft', 'cost_pc', 'cost', 'mark_up', 'rate',
        'm_cost', 'calculated_cost', 'cost_inch', 'unit_box', 'price_box', 'price_piece', 'box_weight', 'ft_box',
        'inch_box', 'price_inch', 'vent', 'xfix', 'fix', 'grid', 'lam_im_gx', 'two_panel_frame', 'three_panel_frame',
        'four_panel_frame', 'panel', 'price_sq_ft', 'stf', 'labor_sta', 'labor_field', 'profit',
        'purchase_price', 'markup_percentage', 'purchase_by_piece', 'purchase_by_bnd_99', 'purchase_by_bnd_54',
        'purchase_by_bnd_70', 'purchase_by_bnd_63', 'purchase_by_bnd_77', 'purchase_by_bnd_49', 'purchase_by_bnd_42',
        'purchase_by_bnd_396', 'purchase_by_bnd_510', 'purchase_by_bnd_341', 'purchase_by_bnd_81',
        'purchase_by_bnd_72', 'purchase_by_bnd_90'
    ];
    
    public $timestamps = false;
}
