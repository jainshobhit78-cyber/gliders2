<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('id');
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->string('subject')->nullable()->after('email');
            $table->text('reply_text')->nullable()->after('message');
            $table->timestamp('replied_at')->nullable()->after('reply_text');
            $table->string('status')->default('pending')->after('replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'subject', 'reply_text', 'replied_at', 'status']);
        });
    }
};
