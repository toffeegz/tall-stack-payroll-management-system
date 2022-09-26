<?php

namespace App\Repositories\Payslip;

use App\Models\Payslip;
use App\Repositories\Base\BaseRepository;

class PayslipRepository extends BaseRepository implements PayslipRepositoryInterface
{

  /**
   * PayslipRepository constructor.
   *
   * @param Payslip $model
   */

  public function __construct(Payslip $model)
  {
    parent::__construct($model);
  }
}
