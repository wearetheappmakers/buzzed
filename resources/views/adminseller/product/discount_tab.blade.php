@include('adminseller.discount.discount_list', array('discounts'=> $discounts, 'selected_discount' => isset($product->discounts[0]->id) ? $product->discounts[0]->id :''))