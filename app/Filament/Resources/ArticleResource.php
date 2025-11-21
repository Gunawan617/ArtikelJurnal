<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers\ReferencesRelationManager;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Artikel')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', \Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('category')
                        ->label('Kategori')
                        ->default('ARTIKEL ILMIAH')
                        ->required()
                        ->helperText('Contoh: ARTIKEL ILMIAH, PENELITIAN, REVIEW, dll'),

                    Forms\Components\Select::make('category_color')
                        ->label('Warna Badge')
                        ->options([
                            'orange' => 'Orange',
                            'blue' => 'Blue',
                            'green' => 'Green',
                            'red' => 'Red',
                            'purple' => 'Purple',
                            'yellow' => 'Yellow',
                        ])
                        ->default('orange')
                        ->required(),
                ]),

                Forms\Components\Section::make('Informasi Penulis')->schema([
                    Forms\Components\TextInput::make('author')
                        ->label('Nama Penulis')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Nama lengkap penulis artikel'),

                    Forms\Components\TextInput::make('author_institution')
                        ->label('Institusi Penulis')
                        ->placeholder('Universitas / Lembaga')
                        ->maxLength(255),

                    Forms\Components\FileUpload::make('author_photo')
                        ->label('Foto Penulis')
                        ->image()
                        ->disk('public')
                        ->directory('articles/authors')
                        ->maxSize(2048)
                        ->helperText('Upload foto penulis artikel (Max 2MB)')
                        ->columnSpanFull(),
                ])->collapsible(),

                Forms\Components\Section::make('Ditinjau Oleh')->schema([
                    Forms\Components\TextInput::make('reviewer_name')
                        ->label('Nama Peninjau')
                        ->maxLength(255)
                        ->helperText('Reviewer yang meninjau artikel'),
                ])->collapsible(),

                Forms\Components\Textarea::make('abstract')
                    ->label('Abstrak / Ringkasan')
                    ->required()
                    ->rows(3)
                    ->helperText('Ringkasan singkat untuk preview'),

                Forms\Components\RichEditor::make('content')
                    ->label('Konten Artikel')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'heading',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'codeBlock',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('keywords')
                    ->label('Kata Kunci')
                    ->required()
                    ->helperText('Pisahkan dengan koma'),
            ]),

            Forms\Components\Section::make('File & Publikasi')->schema([
                Forms\Components\FileUpload::make('pdf_path')
                    ->label('Upload PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('articles/pdfs')
                    ->maxSize(10240)
                    ->helperText('Max 10MB'),

                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar Artikel')
                    ->image()
                    ->disk('public')
                    ->directory('articles/images')
                    ->maxSize(2048)
                    ->helperText('Max 2MB'),

                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi'),

                Forms\Components\Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('author')->label('Penulis')->searchable(),
                Tables\Columns\TextColumn::make('views_count')->label('Views')->sortable()->numeric(),
                Tables\Columns\IconColumn::make('is_published')->label('Published')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('Tanggal')->date(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Status Publikasi'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // Only admin can see all articles
            });
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Artikel')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Judul')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('slug')
                            ->label('Slug')
                            ->copyable()
                            ->badge()
                            ->color('gray'),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('category')
                                    ->label('Kategori')
                                    ->badge()
                                    ->color(fn($record) => $record->category_color ?? 'gray'),

                                Infolists\Components\IconEntry::make('is_published')
                                    ->label('Status Publikasi')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),

                        Infolists\Components\TextEntry::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Belum dipublikasikan'),
                    ])
                    ->columns(1),

                Infolists\Components\Section::make('Informasi Penulis')
                    ->schema([
                        Infolists\Components\ImageEntry::make('author_photo')
                            ->label('Foto Penulis')
                            ->circular()
                            ->height(100)
                            ->defaultImageUrl(url('/images/default-avatar.jpg'))
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('author')
                            ->label('Nama Penulis')
                            ->icon('heroicon-o-user'),

                        Infolists\Components\TextEntry::make('author_institution')
                            ->label('Institusi')
                            ->placeholder('Tidak ada')
                            ->icon('heroicon-o-building-office'),

                        Infolists\Components\TextEntry::make('reviewer_name')
                            ->label('Ditinjau Oleh')
                            ->placeholder('Tidak ada reviewer')
                            ->icon('heroicon-o-eye'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Infolists\Components\Section::make('Konten')
                    ->schema([
                        Infolists\Components\TextEntry::make('abstract')
                            ->label('Abstrak')
                            ->prose()
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('content')
                            ->label('Konten Artikel')
                            ->html()
                            ->prose()
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('keywords')
                            ->label('Kata Kunci')
                            ->badge()
                            ->separator(',')
                            ->color('info'),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('File & Media')
                    ->schema([
                        Infolists\Components\ImageEntry::make('image_path')
                            ->label('Gambar Artikel')
                            ->height(200)
                            ->defaultImageUrl(url('/images/default-article.jpg'))
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('pdf_path')
                            ->label('File PDF')
                            ->formatStateUsing(fn($state) => $state ? 'PDF tersedia' : 'Tidak ada PDF')
                            ->badge()
                            ->color(fn($state) => $state ? 'success' : 'gray')
                            ->url(fn($record) => $record->pdf_path ? asset('storage/' . $record->pdf_path) : null)
                            ->openUrlInNewTab()
                            ->icon(fn($state) => $state ? 'heroicon-o-document-arrow-down' : 'heroicon-o-document'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Infolists\Components\Section::make('Metadata')
                    ->schema([
                        Infolists\Components\TextEntry::make('views_count')
                            ->label('Total Views')
                            ->numeric()
                            ->icon('heroicon-o-eye')
                            ->color('info'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d F Y, H:i'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->dateTime('d F Y, H:i')
                            ->since(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ReferencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    // Permission: Only admin can edit/delete articles
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
