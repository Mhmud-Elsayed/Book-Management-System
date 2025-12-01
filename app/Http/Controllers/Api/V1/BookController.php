<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequests\StoreBookRequest;
use App\Http\Requests\BookRequests\UpdateBookRequest;
use App\Models\Book;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Log;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="Book management endpoints"
 * )
 * 
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     description="Book model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title_en", type="string", example="The Great Gatsby"),
 *     @OA\Property(property="title_ar", type="string", example="غاتسبي العظيم"),
 *     @OA\Property(property="description_en", type="string", example="A classic American novel"),
 *     @OA\Property(property="description_ar", type="string", example="رواية أمريكية كلاسيكية"),
 *     @OA\Property(property="price", type="number", format="float", example=29.99),
 *     @OA\Property(property="author_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="author",
 *         ref="#/components/schemas/Author"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     description="Author model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="F. Scott Fitzgerald"),
 *     @OA\Property(property="bio", type="string", example="American novelist"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="StoreBookRequest",
 *     type="object",
 *     required={"title_en", "title_ar", "description_en", "description_ar", "price", "author_id"},
 *     @OA\Property(property="title_en", type="string", maxLength=255, example="The Great Gatsby"),
 *     @OA\Property(property="title_ar", type="string", maxLength=255, example="غاتسبي العظيم"),
 *     @OA\Property(property="description_en", type="string", example="A classic American novel"),
 *     @OA\Property(property="description_ar", type="string", example="رواية أمريكية كلاسيكية"),
 *     @OA\Property(property="price", type="number", format="float", minimum=0, example=29.99),
 *     @OA\Property(property="author_id", type="integer", example=1)
 * )
 * 
 * @OA\Schema(
 *     schema="UpdateBookRequest",
 *     type="object",
 *     @OA\Property(property="title_en", type="string", maxLength=255, example="The Great Gatsby - Updated"),
 *     @OA\Property(property="title_ar", type="string", maxLength=255, example="غاتسبي العظيم - محدث"),
 *     @OA\Property(property="description_en", type="string", example="Updated description"),
 *     @OA\Property(property="description_ar", type="string", example="الوصف المحدث"),
 *     @OA\Property(property="price", type="number", format="float", minimum=0, example=39.99),
 *     @OA\Property(property="author_id", type="integer", example=1)
 * )
 * 
 * @OA\Schema(
 *     schema="BookResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Books retrieved successfully"),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="language", type="string", example="en"),
 *         @OA\Property(
 *             property="books",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Book")
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="SingleBookResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Book retrieved successfully"),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="book", ref="#/components/schemas/Book")
 *     )
 * )
 */

class BookController extends Controller
{
    private $language;

    public function __construct(LanguageService $language)
    {
        $this->language = $language;
    }

    private function getbooks($lang, $books)
    {
        $BookResource = [
            'ar' => 'ArabicBooksResource',
            'en' => 'EnglishBooksResource',
        ];
        if (isset($lang) && array_key_exists($lang, $BookResource)) {
            $BookResourceClass = 'App\\Http\\Resources\\'.$BookResource[$lang];
            $books = $BookResourceClass::collection($books);
        }

        return $books;

    }
 /**
     * @OA\Get(
     *     path="/books",
     *     operationId="getBooks",
     *     tags={"Books"},
     *     summary="Get all books",
     *     description="Returns a list of all books with language support",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Language preference (en, ar)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"en", "ar"}, default="en")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BookResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve books")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $lang = $this->language->detectLanguage($request);
        $books = Book::with('author')->get();
        $books = $this->getbooks($lang, $books);

        return response()->json([
            'success' => true,
            'message' => 'Books retrieved successfully',
            'data' => [
                'language' => $lang,
                'books' => $books],
        ], 200);

    }
    /**
     * @OA\Post(
     *     path="/books",
     *     operationId="createBook",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     description="Create a new book (Authentication required)",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBookRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="book", ref="#/components/schemas/Book")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to create book")
     *         )
     *     )
     * )
     */

    public function store(StoreBookRequest $request)
    {
        $user = auth()->user();
            if(isset($user)&& $user->isEditor() || $user->isAdmin()) {
                 try {
            

            $book = Book::create([
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'price' => $request->price,
                'author_id' => $request->author_id,
            ]);
            if ($book) {
                return response()->json([
                    'success' => true,
                    'message' => 'Book created successfully',
                    'data' => ['book' => $book],
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create book',
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create book ',
            ], 500);
        }
            }
            return response()->json([
                'success'=> false,
                'message'=> 'unauthorised',
            ],401);
       

    }
 /**
     * @OA\Put(
     *     path="/books/{id}",
     *     operationId="updateBook",
     *     tags={"Books"},
     *     summary="Update a book",
     *     description="Update book details (Authentication required)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateBookRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="book", ref="#/components/schemas/Book")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to update book")
     *         )
     *     )
     * )
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $user = auth()->user();
        if(isset($user)&& $user->isEditor() || $user->isAdmin()) {
        try {
            $book = Book::findOrFail($id);
            $updatedBook = $book->update([
                'title_en' => $request->title_en ?? $book->title_en,
                'title_ar' => $request->title_ar ?? $book->title_ar,
                'description_en' => $request->description_en ?? $book->description_en,
                'description_ar' => $request->description_ar ?? $book->description_ar,
                'price' => $request->price ?? $book->price,
                'author_id' => $request->author_id ?? $book->author_id,
            ]);
            if (! $updatedBook) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update book',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully',
                'data' => ['book' => $updatedBook],
            ], 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update book ',
            ], 500);
        }}
         return response()->json([
                'success'=> false,
                'message'=> 'unauthorised',
            ],401);
       
    }
 /**
     * @OA\Delete(
     *     path="/books/{id}",
     *     operationId="deleteBook",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     description="Delete a book (Authentication required)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to delete book")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            Book::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete book ',
            ], 500);
        }
    }
/**
     * @OA\Get(
     *     path="/books/{id}",
     *     operationId="getBook",
     *     tags={"Books"},
     *     summary="Get a single book",
     *     description="Returns a single book by ID with language support",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Language preference (en, ar)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"en", "ar"}, default="en")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SingleBookResponse")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve book")
     *         )
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        $lang = $this->language->detectLanguage($request);

        try {
            $book = Book::with('author')->findOrFail($id);
            $book = $this->getbooks($lang, collect([$book]))->first();

            return response()->json([
                'success' => true,
                'message' => 'Book retrieved successfully',
                'data' => ['book' => $book],
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve book ',
            ], 500);
        }
    }
}
