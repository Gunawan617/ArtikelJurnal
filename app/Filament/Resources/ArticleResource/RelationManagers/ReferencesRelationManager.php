<?php

namespace App\Filament\Resources\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReferencesRelationManager extends RelationManager
{
    protected static string $relationship = 'references';
    protected static ?string $title = 'Daftar Referensi';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('author')
                ->label('Penulis')
                ->required(),
            
            Forms\Components\TextInput::make('title')
                ->label('Judul')
                ->required(),
            
            Forms\Components\TextInput::make('year')
                ->label('Tahun')
                ->required(),
            
            Forms\Components\TextInput::make('journal')
                ->label('Jurnal'),
            
            Forms\Components\TextInput::make('doi')
                ->label('DOI'),
            
            Forms\Components\TextInput::make('url')
                ->label('URL')
                ->url(),
            
            Forms\Components\TextInput::make('order')
                ->label('Urutan')
                ->numeric()
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author')->label('Penulis'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->limit(50),
                Tables\Columns\TextColumn::make('year')->label('Tahun'),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
