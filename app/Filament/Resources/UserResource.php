<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kelola User';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi User')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'pembaca' => 'Pembaca',
                    ])
                    ->required()
                    ->default('pembaca')
                    ->helperText('Admin: Kelola semua | Pembaca: Hanya baca & komentar'),
                
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->helperText('Kosongkan jika tidak ingin mengubah password'),
            ]),
            
            Forms\Components\Section::make('Profile Penulis')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Gelar')
                    ->placeholder('Dr., Prof., M.Kom, S.Kom, dll')
                    ->maxLength(255)
                    ->helperText('Gelar akademik atau profesional'),
                
                Forms\Components\TextInput::make('institution')
                    ->label('Institusi')
                    ->placeholder('Universitas / Lembaga')
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('bio')
                    ->label('Bio')
                    ->rows(3)
                    ->helperText('Deskripsi singkat tentang penulis (akan ditampilkan di artikel)'),
                
                Forms\Components\FileUpload::make('photo')
                    ->label('Foto Profil')
                    ->image()
                    ->directory('profiles')
                    ->helperText('Foto profil penulis'),
            ])->description('Informasi ini akan otomatis digunakan saat membuat artikel'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Role')
                    ->colors([
                        'danger' => 'admin',
                        'success' => 'pembaca',
                    ])
                    ->icons([
                        'heroicon-o-shield-check' => 'admin',
                        'heroicon-o-user' => 'pembaca',
                    ]),
                
                Tables\Columns\BadgeColumn::make('is_banned')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Banned' : 'Aktif')
                    ->colors([
                        'danger' => fn ($state) => $state === true,
                        'success' => fn ($state) => $state === false,
                    ])
                    ->icons([
                        'heroicon-o-no-symbol' => fn ($state) => $state === true,
                        'heroicon-o-check-circle' => fn ($state) => $state === false,
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filter Role')
                    ->options([
                        'admin' => 'Admin',
                        'pembaca' => 'Pembaca',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ban')
                    ->label('Ban')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('ban_reason')
                            ->label('Alasan Ban')
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->update([
                            'is_banned' => true,
                            'banned_at' => now(),
                            'ban_reason' => $data['ban_reason'],
                        ]);
                    })
                    ->visible(fn (User $record) => !$record->is_banned),
                Tables\Actions\Action::make('unban')
                    ->label('Unban')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->update([
                            'is_banned' => false,
                            'banned_at' => null,
                            'ban_reason' => null,
                        ]);
                    })
                    ->visible(fn (User $record) => $record->is_banned),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Hanya admin yang bisa akses
    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
