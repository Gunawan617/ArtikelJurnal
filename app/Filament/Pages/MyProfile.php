<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profile Saya';
    protected static ?int $navigationSort = 99;
    protected static string $view = 'filament.pages.my-profile';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $user = auth()->user();
        
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $user->bio,
            'photo' => $user->photo,
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->helperText('Email tidak dapat diubah'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Profile Penulis')
                    ->description('Informasi ini akan otomatis digunakan saat Anda membuat artikel')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('Bio')
                            ->rows(4)
                            ->helperText('Deskripsi singkat tentang Anda (akan ditampilkan di artikel)')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('profiles')
                            ->helperText('Upload foto profil Anda')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Ubah Password')
                    ->description('Kosongkan jika tidak ingin mengubah password')
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->dehydrated(false)
                            ->rules(['required_with:new_password']),
                        
                        Forms\Components\TextInput::make('new_password')
                            ->label('Password Baru')
                            ->password()
                            ->dehydrated(false)
                            ->rules(['min:8', 'confirmed']),
                        
                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->dehydrated(false),
                    ])
                    ->columns(3),
            ])
            ->statePath('data');
    }
    
    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();
        
        // Validate current password if trying to change password
        if (!empty($data['new_password'])) {
            if (empty($data['current_password'])) {
                Notification::make()
                    ->title('Password saat ini harus diisi')
                    ->danger()
                    ->send();
                return;
            }
            
            if (!Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->title('Password saat ini salah')
                    ->danger()
                    ->send();
                return;
            }
            
            $user->password = Hash::make($data['new_password']);
        }
        
        // Update profile
        $user->name = $data['name'];
        $user->bio = $data['bio'];
        $user->photo = $data['photo'];
        $user->save();
        
        Notification::make()
            ->title('Profile berhasil diupdate')
            ->success()
            ->send();
    }
    

}
