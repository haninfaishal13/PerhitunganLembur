<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class OvertimeTest extends TestCase
{
    // Setting update value
    public function testSettingKeyInvalid()
    {
        $this->patch('api/settings', ['key' => 'abcdef'])->assertStatus(422);
    }
    public function testSettingValueInvalid()
    {
        $this->patch('api/settings', ['key' => 'overtime_method', 'value' => 100])->assertStatus(422);
    }
    public function testSettingSuccess()
    {
        $this->patch('api/settings', ['key' => 'overtime_method', 'value' => 1])->assertStatus(200);
    }
    // Employee store name & salary
    public function testEmployeeNameDatatypeIsWrong()
    {
        $this->post('api/employees', ['name' => 1234])->assertStatus(422);
    }
    public function testEmployeeNameCharLengthLessFromValidation()
    {
        $this->post('api/employees', ['name' => 'a'])->assertStatus(422);
    }
    public function testEmployeeSalaryDatatypeIsWrong()
    {
        $this->post('api/employees', ['name' => 'aaa', 'salary' => 'aaaaa'])->assertStatus(422);
    }
    public function testEmployeeSalaryLessThan2M()
    {
        $this->post('api/employees', ['name' => 'aaa', 'salary' => 2000])->assertStatus(422);
    }
    public function testEmployeeSuccess()
    {
        $this->post('api/employees', ['name' => 'Endah', 'salary' => 5000000])->assertStatus(201);
    }
    // Overtime store employee_id,
    public function testOvertimeEmployeeIdDatatypeNotCorrect()
    {
        $this->post('api/overtimes', ['employee_id' => 'aaa'])->assertStatus(422);
    }
    public function testOvertimeEmployeeIdNotExist()
    {
        $this->post('api/overtimes', ['employee_id' => 200])->assertStatus(422);
    }
    public function testOvertimeDateDatatypeNotCorrect()
    {
        $this->post('api/overtimes', ['employee_id' => 1, 'date' => 'asdfadfsafasdf'])->assertStatus(422);
    }
    public function testOvertimeDateSame()
    {
        $this->post('api/overtimes', ['employee_id' => 1, 'date' => '17-11-2021'])->assertStatus(422);
    }
    public function testOvertimeTimeStartAfterTimeEnd()
    {
        $this->post('api/overtimes', ['employee_id' => 1, 'date' => '18-11-2021', 'time_started' => '20:00', 'time_ended' => '18:00'])->assertStatus(422);
    }
    public function testOvertimeSuccess()
    {
        $this->post('api/overtimes', ['employee_id' => 1, 'date' => '22-11-2021', 'time_started' => '20:00', 'time_ended' => '22:00'])->assertStatus(201);
    }
    // Calculate Overtime
    public function testCalculateOvertimePaymentMisformatMonth()
    {
        $this->get('api/overtime-pays/calculate?month=11-2021')->assertStatus(422)->getContent();
    }
    public function testCalculateOvertimePaymentSuccess()
    {
        $this->get('api/overtime-pays/calculate?month=2021-11')->assertStatus(200)->getContent();
    }
}
