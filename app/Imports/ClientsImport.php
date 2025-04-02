<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class ClientsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // التحقق من وجود employee_id
        $employeeId = $this->validateId($row['employee_id'] ?? null, Employee::class);
        if ($employeeId === false) {
            return null;
        }

        // التحقق من وجود branch_id
        $branchId = $this->validateId($row['branch_id'] ?? null, Branch::class);
        if ($branchId === false) {
            return null;
        }

        return new Client([
            'trade_name'            => $this->nullIfEmpty($row['trade_name'] ?? null),
            'first_name'            => $this->nullIfEmpty($row['first_name'] ?? null),
            'last_name'             => $this->nullIfEmpty($row['last_name'] ?? null),
            'phone'                 => $this->nullIfEmpty($row['phone'] ?? null),
            'mobile'                => $this->nullIfEmpty($row['mobile'] ?? null),
            'street1'               => $this->nullIfEmpty($row['street1'] ?? null),
            'street2'               => $this->nullIfEmpty($row['street2'] ?? null),
            'category'              => $this->nullIfEmpty($row['category'] ?? null),
            'city'                  => $this->nullIfEmpty($row['city'] ?? null),
            'region'                => $this->nullIfEmpty($row['region'] ?? null),
            'postal_code'           => $this->nullIfEmpty($row['postal_code'] ?? null),
            'country'               => $this->nullIfEmpty($row['country'] ?? null),
            'tax_number'            => $this->nullIfEmpty($row['tax_number'] ?? null),
            'commercial_registration' => $this->nullIfEmpty($row['commercial_registration'] ?? null),
            'credit_limit'          => $this->formatNumeric($row['credit_limit'] ?? null),
            'credit_period'         => $this->formatNumeric($row['credit_period'] ?? null),
            'printing_method'       => $this->nullIfEmpty($row['printing_method'] ?? null),
            'opening_balance'       => $this->formatBalance($row['opening_balance'] ?? null),
            'opening_balance_date'  => $this->formatDate($row['opening_balance_date'] ?? null),
            'code'                  => $this->nullIfEmpty($row['code'] ?? null),
            'currency'              => $this->nullIfEmpty($row['currency'] ?? null),
            'email'                 => $this->nullIfEmpty($row['email'] ?? null),
            'client_type'           => $this->nullIfEmpty($row['client_type'] ?? null),
            'notes'                 => $this->nullIfEmpty($row['notes'] ?? null),
            'employee_id'           => $employeeId,
            'branch_id'             => $branchId,
            'status'                => $this->nullIfEmpty($row['status'] ?? null),
        ]);
    }

    /**
     * تحويل القيمة إلى null إذا كانت فارغة
     */
    private function nullIfEmpty($value)
    {
        return $value === '' || $value === null ? null : $value;
    }

    /**
     * تنسيق الأرقام العشرية
     */
    private function formatNumeric($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        $cleaned = preg_replace('/[^\d.-]/', '', $value);
        return $cleaned === '' ? null : (float)$cleaned;
    }

    /**
     * تنسيق خاص لـ opening_balance
     */
    private function formatBalance($value)
    {
        if (is_null($value) || $value === '') {
            return 0;
        }

        $cleaned = preg_replace('/[^\d.-]/', '', $value);
        return round((float)$cleaned, 2);
    }

    /**
     * تنسيق التاريخ
     */
    private function formatDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * التحقق من صحة ID
     */
    private function validateId($id, $model)
    {
        if (empty($id)) {
            return null;
        }

        return $model::where('id', $id)->exists() ? $id : false;
    }

    /**
     * قواعد التحقق
     */
    public function rules(): array
    {
        return [
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric',
            'credit_period' => 'nullable|numeric',
            'opening_balance_date' => 'nullable|date',
            'employee_id' => 'nullable|exists:employees,id',
            'branch_id' => 'nullable|exists:branches,id',
            'email' => 'nullable|email',
        ];
    }

    /**
     * معالجة الأخطاء
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            logger()->error('Failed to import row: ' . json_encode($failure->row()) .
                          ' Errors: ' . json_encode($failure->errors()));
        }
    }
}
