<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->unsignedInteger('id')->nullable()->default(null)->comment('兼容原数据和功能，对应uums的companies.id，对应erp的finance_cost_company.company_id')->unique();
            $table->unsignedInteger('ns_internal_id')->nullable()->default(null)->comment('NS内部唯一标识，兼容原数据和功能，对应uums的companies.ns_internal_id，对应erp的finance_cost_company.ns_internal_id');
            $table->string('name')->comment('公司名称');
            $table->string('foreign_name')->default('')->comment('外语名称');
            $table->string('simple_name')->default('')->comment('简称');
            $table->unsignedTinyInteger('type')->default(1)->comment('公司类型；1：母公司；2：子公司；3：分公司；');
            $table->char('parent_uuid', 32)->nullable()->default(null)->comment('上级公司uuid, 默认为母公司')->index();
            $table->char('one_level_uuid', 32)->nullable()->default(null)->comment('对应母公司的uuid')->index();
            $table->char('two_level_uuid', 32)->nullable()->default(null)->comment('对应子公司的uuid')->index();
            $table->string('code')->comment('主体标识');
            $table->char('country_code',2)->comment('国家代码');
            $table->string('country_name')->comment('国家名称');
            $table->string('contacts')->default('')->comment('联系人');
            $table->text('profile')->nullable()->default(null)->comment('公司简介');
            $table->unsignedTinyInteger('is_show')->default(1)->comment('是否展示；0：不展示；1：展示；');
            $table->unsignedTinyInteger('status')->default(1)->comment('公司状态；0：已注销；1：运营中；');
            $table->tinyInteger('time_zone')->default(0)->comment('公司时差');
            $table->timestamps();
        });

        Schema::create('company_addresses', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('company_uuid', 32)->comment('对应companies.uuid')->index();
            $table->unsignedTinyInteger('type')->nullable(false)->comment('1：公司地址；2：办公室地址；3：仓库地址；');
            $table->string('name')->default('')->comment('中文名称');
            $table->char('country_code',2)->comment('国家代码');
            $table->string('country_name')->comment('国家名称');
            $table->string('province')->default('')->comment('省');
            $table->string('city')->default('')->comment('市');
            $table->string('area')->default('')->comment('区');
            $table->string('address')->default('')->comment('详细地址');
            $table->string('postcode')->default('')->comment('邮编');
            $table->string('tel')->default('')->comment('电话号码'); // 027-123
            $table->string('foreign_name')->default('')->comment('外语名称');
            $table->char('foreign_country_code',2)->comment('国家代码');
            $table->string('foreign_country_name')->default('')->comment('国家名称(外语)');
            $table->string('foreign_province')->default('')->comment('省(外语)');
            $table->string('foreign_city')->default('')->comment('市(外语)');
            $table->string('foreign_area')->default('')->comment('区(外语)');
            $table->string('foreign_address')->default('')->comment('详细地址(外语)');
            $table->string('foreign_postcode')->default('')->comment('邮编');
            $table->string('foreign_tel')->default('')->comment('电话号码'); // 027-123
            $table->text('comment')->nullable()->default(null)->comment('简介说明');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态；1：使用中；0：已注销；');
            $table->timestamps();
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用，company_addresses.id')->unique();
        });

        Schema::create('company_address_contacts', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('company_address_uuid', 32)->comment('对应company_addresses.uuid')->index();
            $table->string('name')->default('')->comment('联系人');
            $table->string('tel')->default('')->comment('电话号码'); // 027-123
            $table->unsignedTinyInteger('type')->comment('信息类型；1：中文；2：英文；');
            $table->timestamps();
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用 company_address_contacts.id')->index();
        });

        Schema::create('company_tax_info', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('company_uuid', 32)->comment('对应companies.uuid')->index();
            $table->char('country_code',2)->comment('国家代码');
            $table->string('country_name')->comment('国家名称');
            $table->string('tax_number')->comment('税号');
            $table->timestamps();
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用 company_tax_info.id')->index();
        });

        Schema::create('company_banks', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('company_uuid', 32)->comment('对应companies.uuid')->index();
            $table->string('bank_name')->comment('银行名称');
            $table->string('account_name')->comment('收款人/账户名');
            $table->string('check_address')->default('')->comment('支票接收地址');
            $table->json('other_info')->nullable()->default(null)->comment('银行的其他信息');
            $table->text('comment')->nullable()->default(null)->comment('简介说明');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态；1：使用中；0：已注销；');
            $table->timestamps();
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用 company_pay.id')->index();
        });

        Schema::create('company_bank_accounts', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('company_bank_uuid', 32)->comment('对应company_banks.uuid')->index();
            $table->char('currency_code', 3)->comment('币种代码');
            $table->string('account_number')->comment('账号');
            $table->unsignedInteger('payment_method_id')->nullable()->default(null)->comment('付款方式ID');
            $table->string('payment_method_name')->comment('付款方式名称');
            $table->json('other_info')->nullable()->default(null)->comment('其他账户信息');
            $table->timestamps();
            $table->unique(['payment_method_id', 'currency_code']); // 付款方式-币值 联合唯一索引
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用 company_bank_accounts.id')->index();
        });

        Schema::create('company_status_logs', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('model_uuid', 32)->comment('模型的uuid');
            $table->string('model_type')->comment('多态类型');
            $table->index(['model_uuid', 'model_type']);
            $table->char('admin_uuid', 32)->nullable()->default(null)->comment('操作人uuid')->index();
            $table->string('admin_name')->default('')->comment('操作人名称');
            $table->string('action_name')->default('')->comment('操作名称(路由名)');
            $table->unsignedTinyInteger('old_status')->nullable()->default(null)->comment('更新前的状态');
            $table->unsignedTinyInteger('new_status')->comment('更新后的状态');
            $table->string('comment')->default('')->comment('备注');
            $table->timestamps();
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用 company_status_logs.id')->index();
        });

        Schema::create('company_media', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('model_uuid', 32)->comment('模型的uuid');
            $table->string('model_type')->comment('多态类型');
            $table->index(['model_uuid', 'model_type']);
            $table->char('admin_uuid', 32)->nullable()->default(null)->comment('操作人uuid')->index();
            $table->string('admin_name')->default('')->comment('操作人名称');
            $table->string('name')->comment('文件原始名称');
            $table->string('path')->comment('文件存储路径');
            $table->unsignedInteger('size')->default(0)->comment('文件大小, 单位 B');
            $table->timestamps();
            $table->unsignedInteger('id')->nullable()->comment('已废弃 供迁移数据时使用 media.id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_media');
        Schema::dropIfExists('company_status_logs');
        Schema::dropIfExists('company_bank_accounts');
        Schema::dropIfExists('company_banks');
        Schema::dropIfExists('company_tax_info');
        Schema::dropIfExists('company_address_contacts');
        Schema::dropIfExists('company_addresses');
        Schema::dropIfExists('companies');
    }
}
