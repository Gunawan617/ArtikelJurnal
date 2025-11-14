<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserReportResource\Pages;
use App\Filament\Resources\UserReportResource\RelationManagers;
use App\Models\UserReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserReportResource extends Resource
{
    protected static ?string $model = UserReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    
    protected static ?string $navigationLabel = 'Laporan User';
    
    protected static ?string $navigationGroup = 'Moderasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'resolved' => 'Resolved',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('admin_notes')
                    ->label('Catatan Admin')
                    ->rows(3),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Laporan')
                    ->schema([
                        Infolists\Components\TextEntry::make('reporter.name')
                            ->label('Pelapor'),
                        Infolists\Components\TextEntry::make('reportedUser.name')
                            ->label('User Dilaporkan'),
                        Infolists\Components\TextEntry::make('reportable_type')
                            ->label('Tipe Konten')
                            ->formatStateUsing(fn ($state) => $state === 'App\Models\Discussion' ? 'Diskusi' : 'Balasan'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'reviewed' => 'primary',
                                'resolved' => 'success',
                            }),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Laporan')
                            ->dateTime('d M Y H:i'),
                    ])->columns(2),
                Infolists\Components\Section::make('Detail Laporan')
                    ->schema([
                        Infolists\Components\TextEntry::make('reason')
                            ->label('Alasan Laporan')
                            ->columnSpanFull(),
                    ]),
                Infolists\Components\Section::make('Tindakan Admin')
                    ->schema([
                        Infolists\Components\TextEntry::make('admin_notes')
                            ->label('Catatan Admin')
                            ->default('Belum ada catatan')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('reviewer.name')
                            ->label('Ditinjau Oleh')
                            ->default('-'),
                        Infolists\Components\TextEntry::make('reviewed_at')
                            ->label('Tanggal Ditinjau')
                            ->dateTime('d M Y H:i')
                            ->default('-'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Pelapor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reportedUser.name')
                    ->label('User Dilaporkan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reportable_type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => $state === 'App\Models\Discussion' ? 'Diskusi' : 'Balasan'),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Alasan')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'reviewed',
                        'success' => 'resolved',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'resolved' => 'Resolved',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ban_user')
                    ->label('Ban User')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('ban_reason')
                            ->label('Alasan Ban')
                            ->required(),
                    ])
                    ->action(function (UserReport $record, array $data) {
                        $record->reportedUser->update([
                            'is_banned' => true,
                            'banned_at' => now(),
                            'ban_reason' => $data['ban_reason'],
                        ]);
                        
                        $record->update([
                            'status' => 'resolved',
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                            'admin_notes' => 'User telah di-ban: ' . $data['ban_reason'],
                        ]);
                    })
                    ->visible(fn (UserReport $record) => !$record->reportedUser->is_banned),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserReports::route('/'),
            'view' => Pages\ViewUserReport::route('/{record}'),
            'edit' => Pages\EditUserReport::route('/{record}/edit'),
        ];
    }
}
