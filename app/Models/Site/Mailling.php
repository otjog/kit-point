<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Mailling extends Model
{
    protected $casts = [
        'options' => 'array',
    ];

    public function customer_group()
    {
        return $this->belongsTo(    'App\Models\Shop\CustomerGroup', 'customer_group_id');
    }

    public function getActiveMaillings()
    {
        $maillings = self::where('active', 1)
            ->select('alias', 'name', 'file_src', 'time', 'customer_group_id', 'options')
            ->with(['customer_group' => function($query){
                $query->with('customers');
            }])
            ->get();

        $maillings = $this->addNormalizeTime($maillings);

        $maillings = $this->addMailList($maillings);

        return $maillings;
    }

    public function getActiveMaillingById($id)
    {
        $maillings = self::where('active', 1)
            ->where('id', $id)
            ->select('alias', 'name', 'file_src', 'time', 'customer_group_id', 'options')
            ->with(['customer_group' => function($query){
                $query->with('customers');
            }])
            ->get();

        $maillings = $this->addNormalizeTime($maillings);

        $maillings = $this->addMailList($maillings);

        return $maillings;
    }

    protected function addNormalizeTime ($events)
    {
        $datetime = [
            'year'  => date('Y'),
            'month' => date('m'),
            'day'   => date('d'),
            'hour'  => date('H'),
            'min'   => date('i'),
        ];

        foreach ($events as $event) {
            list($min, $hour, $day, $month, $dayOfWeek) = explode(' ', $event->time);

            if($min !== '*')
                $datetime['min'] = $min;
            if($hour !== '*')
                $datetime['hour'] = $hour;
            if($day !== '*')
                $datetime['day'] = $day;
            if($month !== '*')
                $datetime['month'] = $month;

            if($dayOfWeek === '*')
                $dayOfWeek = date('N');

            $event->datetime = $datetime['year'] . '-' . $datetime['month'] . '-' . $datetime['day'] . ' ' . $datetime['hour'] . ':' . $datetime['min'] . ':00';

            $event->timestamp = strtotime($event->datetime);

            $event->dayOfWeek = $dayOfWeek;

        }

        return $events;
    }

    /**
     * Добавляет Maillist к каждому эксземпляру рассылки
     *
     * Если у экземпляра рассылки указан file_src, то список адресов для рассылки берется
     * из указанного текстового файла. При этом значение поля customer_group_id учитывается только
     * для того, чтобы установить цену при расслки товарных предложений. Если customer_group_id,
     * то будет учитываться группа по умолчанию.
     * Чтобы сделать рассылку для существующих пользователей нужно, оставить поле file_src = null
     * и указать customer_group_id
     *
     * @param self $maillings
     * @return self
     */
    protected function addMailList($maillings)
    {
        foreach ($maillings as $mailling) {
            if ($mailling->file_src !== null) {
                $mailling->mailList = $this->getMailListFromFile($mailling->file_src);
            } else {
                $mailling->mailList = $this->getMailListFromDb($mailling->customer_group);
            }
        }

        return $maillings;
    }

    protected function getMailListFromFile($filepath)
    {
        $data = [];

        if (is_file(public_path($filepath))) {
            $strings = file(public_path($filepath));
            foreach ($strings as $string) {
                $string = str_ireplace(["\t", "\n", "\r", "\0", "\x0B"],' ', $string);
                $delimeterPosition = stripos($string, ' ');

                $data[] = [
                    'email' => substr($string, 0, $delimeterPosition),
                    'full_name' => trim(substr($string, $delimeterPosition))
                ];

            }
        }

        return $data;
    }

    protected function getMailListFromDb($customerGroup)
    {
        if ($customerGroup !== null) {
           if (isset($customerGroup->customers) && $customerGroup->customers !== null) {
               return $customerGroup->customers->toArray();
           }
        }
    }

}
