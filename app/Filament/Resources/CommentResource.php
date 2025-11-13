<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Komentar';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('article_id')
                ->relationship('article', 'title')
                ->required(),
            
            Forms\Components\Textarea::make('content')
                ->label('Komentar')
                ->required(),
            
            Forms\Components\Toggle::make('approved')
                ->label('Setujui')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('article.title')->label('Artikel')->limit(30),
                Tables\Columns\TextColumn::make('content')->label('Komentar')->limit(50),
                Tables\Columns\IconColumn::make('approved')->label('Approved')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('approved')->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListComments::route('/'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

    // Hanya admin yang bisa akses panel komentar
    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
