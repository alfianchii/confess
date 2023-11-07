<?php

namespace App\Exports\Users;

use App\Models\User;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    WithProperties,
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomValueBinder,
    WithStyles,
};
use PhpOffice\PhpSpreadsheet\Cell\{
    DefaultValueBinder,
    Cell,
    DataType,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOfUsersExport extends DefaultValueBinder
implements WithProperties, FromCollection, WithHeadings, WithMapping, WithCustomValueBinder, WithStyles
{
    // ---------------------------------
    // TRAITS
    use Exportable;


    // ---------------------------------
    // PROPERTIES
    protected string $gender;



    // ---------------------------------
    // CORES
    public function properties(): array
    {
        return [
            'title'          => 'All of Users Export',
            'description'    => "Total of users who have registered on the " . config('web_config')['TEXT_WEB_TITLE'],
            'subject'        => 'Users',
            'keywords'       => 'Users,export,spreadsheet',
            'category'       => 'Users',
        ];
    }

    public function collection()
    {
        return User::with(["userRole.role", "officer", "student"])
            ->latest()
            ->get();
    }


    // ---------------------------------
    // UTILITIES
    public function headings(): array
    {
        return [
            'Full name',
            'Username',
            'NIK',
            'Role',
            'Unique',
            'Gender',
            'Email',
            'Email verified at',
            'Profile picture',
            'Active',
            'Last login at',
            'Created at',
        ];
    }
    public function map($user): array
    {
        return [
            $user->full_name,
            $user->username,
            $user->nik,
            $user->userRole->role->role_name,
            $user->officer->nip ?? $user->student->nisn,
            $user->gender,
            $user->email ?? "-",
            $user->email_verified_at ?? "-",
            $user->profile_picture ?? "-",
            $user->flag_active,
            $user->last_login_at ?? "-",
            $user->created_at->format('j F Y, \a\t H.i'),
        ];
    }
    public function bindValue(Cell $cell, $value)
    {
        // Convert numeric into text
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // Return default behavior
        return parent::bindValue($cell, $value);
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("1")->getFont()->setBold(true);
    }
}
