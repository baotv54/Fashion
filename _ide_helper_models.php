<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $province
 * @property string $district
 * @property string $ward
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereWard($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttributeValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereUpdatedAt($value)
 */
	class Attribute extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attribute $attribute
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VariantAttributeValue> $variantValues
 * @property-read int|null $variant_values_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttributeValue whereValue($value)
 */
	class AttributeValue extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $subtitle
 * @property string $image
 * @property string|null $link
 * @property string $target
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUpdatedAt($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereUpdatedAt($value)
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $chat_session_id
 * @property string $role
 * @property string $message
 * @property string|null $product_ids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ChatSession $session
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereChatSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereUpdatedAt($value)
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $session_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatMessage> $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession whereSessionToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatSession whereUserId($value)
 */
	class ChatSession extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comparison whereUserId($value)
 */
	class Comparison extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject Chủ đề liên hệ
 * @property string $message
 * @property string $status
 * @property string|null $admin_reply
 * @property \Illuminate\Support\Carbon|null $replied_at
 * @property int|null $replied_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $repliedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact replied()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereAdminReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereRepliedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereRepliedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $additional_cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost whereAdditionalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cost whereUpdatedAt($value)
 */
	class Cost extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $value
 * @property string $min_cart_value
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int|null $usage_limit
 * @property int $used
 * @property string|null $image
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMinCartValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereValue($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereUpdatedAt($value)
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUserId($value)
 */
	class Favorite extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image_path
 * @property int|null $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $imageable_type
 * @property int $imageable_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property string $image_path
 * @property string|null $image_type
 * @property array<array-key, mixed> $vector
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImageVector whereVector($value)
 */
	class ImageVector extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int|null $variant_id
 * @property int $quantity
 * @property string|null $name_cost
 * @property string $additional_cost
 * @property string $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\ProductVariant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereAdditionalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereNameCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouse whereVariantId($value)
 */
	class ImportWarehouse extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $import_warehouse_id
 * @property int|null $product_id
 * @property int|null $variant_id
 * @property int $quantity
 * @property int $stock
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\ProductVariant|null $variant
 * @property-read \App\Models\ImportWarehouseMain $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereImportWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail whereVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseDetail withoutTrashed()
 */
	class ImportWarehouseDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property int|null $supplier_id
 * @property int|null $user_id
 * @property string|null $note
 * @property string $total_price
 * @property string|null $discount
 * @property string|null $additional_cost
 * @property string|null $cost_name
 * @property string|null $import_date
 * @property string $status
 * @property string|null $payment_status
 * @property string|null $payment_method
 * @property string|null $payment_amount
 * @property string|null $payment_date
 * @property string|null $payment_reference
 * @property string $import_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ImportWarehouseDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Supplier|null $supplier
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereAdditionalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereCostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereImportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereImportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImportWarehouseMain withoutTrashed()
 */
	class ImportWarehouseMain extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logo whereUpdatedAt($value)
 */
	class Logo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $order_code
 * @property string|null $partner_code
 * @property int|null $user_id
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string|null $province
 * @property string|null $district
 * @property string|null $ward
 * @property string|null $note
 * @property string $subtotal
 * @property string $discount
 * @property string $shipping_fee
 * @property string $total
 * @property string $payment_method
 * @property string $status
 * @property string|null $cancel_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $details
 * @property-read int|null $details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCancelReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePartnerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereWard($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int|null $variant_id
 * @property string $product_name
 * @property int $quantity
 * @property string $price
 * @property string|null $variant_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Product|null $products
 * @property-read \App\Models\ProductVariant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereVariantDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereVariantId($value)
 */
	class OrderDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string $media_type
 * @property string|null $media_path
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereMediaPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Popup whereUpdatedAt($value)
 */
	class Popup extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $post_category_id
 * @property string $title
 * @property string $content
 * @property string|null $image
 * @property string $created_at
 * @property string $author
 * @property int $is_visible
 * @property-read \App\Models\PostCategory $postCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereUpdatedAt($value)
 */
	class PostCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $import_price
 * @property string $name
 * @property string $slug
 * @property int|null $brand_id
 * @property int $category_id
 * @property string|null $price
 * @property string|null $discount_price
 * @property string|null $description
 * @property string|null $image
 * @property int $status
 * @property int $has_variants
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttributeValue> $attributeValues
 * @property-read int|null $attribute_values_count
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favoritedByUsers
 * @property-read int|null $favorited_by_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductVariant> $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHasVariants($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImportPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $message_id
 * @property string $path
 * @property string $type
 * @property string|null $mime
 * @property int|null $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductLiveChatMessage|null $message
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatAttachment whereUpdatedAt($value)
 */
	class ProductLiveChatAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $thread_id
 * @property int|null $user_id
 * @property string $sender
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductLiveChatAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\ProductLiveChatThread|null $thread
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatMessage whereUserId($value)
 */
	class ProductLiveChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int|null $user_id
 * @property string $session_token
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductLiveChatMessage> $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereSessionToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLiveChatThread whereUserId($value)
 */
	class ProductLiveChatThread extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int|null $user_id
 * @property int $rating Số sao đánh giá, từ 1 đến 5
 * @property string|null $comment Nội dung đánh giá
 * @property int $is_approved Chỉ hiển thị khi được duyệt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReviewMedia> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReview whereUserId($value)
 */
	class ProductReview extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_review_id
 * @property string $file_path
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductReview $review
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia whereProductReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductReviewMedia whereUpdatedAt($value)
 */
	class ProductReviewMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $slug
 * @property int $product_id
 * @property string $price
 * @property string|null $import_price
 * @property string|null $discount_price
 * @property int $stock
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttributeValue> $attributeValues
 * @property-read int|null $attribute_values_count
 * @property-read \App\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariant> $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereImportPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant withoutTrashed()
 */
	class ProductVariant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $payment_method
 * @property string|null $payment_date
 * @property string|null $payment_reference
 * @property string $return_code
 * @property string $return_status
 * @property string $refund_status
 * @property int|null $supplier_id
 * @property int|null $user_id
 * @property int $total_quantity
 * @property string $total_amount
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReturnDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Supplier|null $supplier
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereRefundStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereTotalQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereUserId($value)
 */
	class PurchaseReturn extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $return_id
 * @property int $product_id
 * @property int|null $variant_id
 * @property int $quantity
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\PurchaseReturn $purchaseReturn
 * @property-read \App\Models\Supplier|null $supplier
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\ProductVariant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReturnDetail whereVariantId($value)
 */
	class ReturnDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $size
 * @property string|null $height_range
 * @property string|null $weight_range
 * @property string|null $chest_range
 * @property string|null $hip_range
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereChestRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereHeightRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereHipRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Size whereWeightRange($value)
 */
	class Size extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $supplier_code
 * @property string $name
 * @property string|null $phone
 * @property string|null $tax_code
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $email
 * @property string $status
 * @property int|null $user_id
 * @property string|null $province
 * @property string|null $district
 * @property string|null $ward
 * @property string|null $address_detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAddressDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereWard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutTrashed()
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $google_id
 * @property string|null $facebook_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property string|null $phone
 * @property string|null $image
 * @property string|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Coupon> $savedCoupons
 * @property-read int|null $saved_coupons_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $variant_id
 * @property int $attribute_value_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attribute|null $attribute
 * @property-read \App\Models\AttributeValue $attributeValue
 * @property-read \App\Models\ProductVariant $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue whereAttributeValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantAttributeValue whereVariantId($value)
 */
	class VariantAttributeValue extends \Eloquent {}
}

