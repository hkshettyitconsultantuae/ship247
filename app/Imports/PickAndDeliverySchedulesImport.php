<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\Location;
use App\Models\PickAndDeliverySchedule;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PickAndDeliverySchedulesImport implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    public $imported_rows_count;
    protected $companies;
    protected $containerSizes;

    public function __construct()
    {
        $this->imported_rows_count = 0;
        $this->companies = Company::pluck('name', 'id')->toArray();
        $this->containerSizes = ContainerSizes::pluck('display_label', 'value')->toArray();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $container_size = array_search($row['container_size'], $this->containerSizes);
        $company_id = array_search($row['company'], $this->companies);
        $valid_till_date = Carbon::parse('1899-12-30')
            ->addDays($row['valid_till'])
            ->toDateString();
        $origin_id = Location::where('code', $row['origin'])->first()->id ?? 0;
        $destination_id = Location::where('code', $row['destination'])->first()->id ?? 0;

        if ($container_size === FALSE || $company_id === FALSE || $origin_id === 0 || $destination_id === 0) {
            return null;
        }

        $this->imported_rows_count++;

        $pickAndDeliverySchedule = new PickAndDeliverySchedule;
        $pickAndDeliverySchedule->origin_id = $origin_id;
        $pickAndDeliverySchedule->destination_id = $destination_id;
        $pickAndDeliverySchedule->container_size = $container_size;
        $pickAndDeliverySchedule->price = $row['price'];
        $pickAndDeliverySchedule->company_id = $company_id;
        $pickAndDeliverySchedule->valid_till = $valid_till_date;

        return $pickAndDeliverySchedule;
    }

    public function rules(): array
    {
        return [
            'origin' => 'required|string|min:5|max:5',
            'destination' => 'required|string|min:5|max:5',
            'container_size' => 'required|string',
            'price' => 'required|numeric',
            'company' => 'required|string',
            'valid_till' => 'required|numeric',
        ];
    }
}
