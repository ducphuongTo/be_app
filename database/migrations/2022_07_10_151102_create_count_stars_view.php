<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountStarsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("
           create view count_star as
            select
                p.id,
                sum(case
                        when r.rating_star=1 then 1
                        else 0
                    end) as one_star,
                sum(case
                        when r.rating_star=2 then 1
                        else 0
                    end) as two_star,
                sum(case
                        when r.rating_star=3 then 1
                        else 0
                    end) as three_star,
                sum(case
                        when r.rating_star=4 then 1
                        else 0
                    end) as four_star,
                sum(case
                        when r.rating_star=5 then 1
                        else 0
                    end) as five_star
            from products p
                     left join reviews r on p.id=r.product_id
            group by p.id
            order by p.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('count_stars_view');
    }
}
