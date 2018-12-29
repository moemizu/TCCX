<?php

use Illuminate\Database\Seeder;

class QuestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'FAST', 'description' => 'ออกเดินทางก่อน 15 นาที'],
            ['name' => 'FIRS', 'description' => 'รับเควสแรกก่อน'],
            ['name' => 'SLNH', 'description' => 'ไม่ต้องทำเควสอาหารกลางวัน'],
            ['name' => 'BOOS', 'description' => 'ทวีคูณคะแนนเควสนั้น 2 เท่า'],
            ['name' => 'RICH', 'description' => 'รับเงินเบี้ยเลี้ยงเพิ่ม 400 บาท'],
            ['name' => 'SKIP', 'description' => 'เปลี่ยนเควสได้ 1 ครั้ง'],
            ['name' => 'MCOM', 'description' => 'ภารกิจลุล่วงทันที 1 ครั้ง'],
            ['name' => 'HOTP', 'description' => 'โยนเควสพิเศษให้กลุ่มอื่นทำ เมื่อทำสำเร็จจะได้รับคะแนนคนละครึ่ง'],
            ['name' => 'SHOT', 'description' => 'ได้รับน้ำดื่มคนละ 1 ขวด พร้อมพัดทีมละ 1 อัน'],
            ['name' => 'STEA', 'description' => 'ขโมยคะแนนครึ่งหนึ่งของเควสที่อีกกลุ่มกำลังส่งต่อหน้า'],
            ['name' => 'BLOK', 'description' => 'บล็อกไม่ให้เควสที่อยากทำถูกเลือกไป'],
            ['name' => 'GURU', 'description' => 'สอบถามผู้เชี่ยวชาญเพื่อขอรับคำแนะนำได้ 1 นาที'],

        ];
        $table = DB::table('quest_items');
        foreach ($data as $entry) {
            $table->insert($entry);
        }
    }
}
