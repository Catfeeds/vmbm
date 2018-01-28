<?php
namespace App\Http\HelperTraits;

use App\Models\AccountLog;

trait LogHelper
{
    /**
     * account log记录
     * @param $data
     * @return AccountLog
     * @throws \Exception
     */
//    public function writeAccountLog($data) {
//        if (!isset($data['obj_type']) || empty($data['obj_type'])) {
//            throw new \Exception('obj_type must be supplied and cannot be empty');
//        }
//        if (!isset($data['obj_id']) || empty($data['obj_id'])) {
//            throw new \Exception('obj_id must be supplied and cannot be empty');
//        }
//        if (!isset($data['direction'])) {
//            $data['direction'] = 1;
//        }
//        if ($data['direction'] != 1 && $data['direction'] != 2) {
//            throw new \Exception('direction must be 1 or 2');
//        }
//        if (isset($data['vm_type']) && !array_key_exists($data['vm_type'], AccountLog::getAllType())) {
//            throw new \Exception('vm_type invalid');
//        }
//        if (isset($data['channel']) && !array_key_exists($data['channel'], AccountLog::getAllChannels())) {
//            throw new \Exception('channel invalid');
//        }
//        if (isset($data['op']) && !array_key_exists($data['op'], AccountLog::getAllop())) {
//            throw new \Exception('op invalid');
//        }
//
//        return AccountLog::create($data);
//    }
//
//    public function logAccount($objType, $objId, $objName, $op, $vmType, $amount, $direction, $balance, $channel, $note = null) {
//        return $this->writeAccountLog([
//            'obj_type'      => $objType,
//            'obj_id'        => $objId,
//            'obj_name'      => $objName,
//            'vm_type'       => $vmType,
//            'amount'        => $amount,
//            'balance'       => $balance,
//            'direction'     => $direction,
//            'op'            => $op,
//            'channel'       => $channel,
//            'note'          => $note,
//        ]);
//    }

    private function logAccount($fromType, $fromId, $fromName, $fromAmount,  $op, $toType, $toId, $toName, $toAmount) {
        return AccountLog::create([
            'from_type'     => $fromType,
            'from_id'       => $fromId,
            'from_name'     => $fromName,
            'from_amount'   => $fromAmount,
            'op'            => $op,
            'to_type'       => $toType,
            'to_id'         => $toId,
            'to_name'       => $toName,
            'to_amount'     => $toAmount,
        ]);
    }



}