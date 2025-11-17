<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Cách chăm sóc hoa hồng tại nhà',
                'content' => "Hoa hồng là loại hoa được yêu thích nhất và là biểu tượng của tình yêu. Để hoa hồng của bạn luôn tươi đẹp, hãy đảm bảo chúng nhận đủ ánh sáng mặt trời mỗi ngày.\n\nTưới nước đều đặn nhưng tránh làm úng rễ. Bón phân định kỳ để cây phát triển khỏe mạnh và ra nhiều hoa. Cắt tỉa những cành héo và lá vàng để cây tập trung dinh dưỡng cho những bông hoa mới.",
                'image' => 'blog/blog-1.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Top 10 loại hoa đẹp nhất cho ngày Valentine',
                'content' => "Valentine là dịp để bạn thể hiện tình yêu với người thân yêu. Hoa hồng đỏ vẫn là lựa chọn hàng đầu với ý nghĩa tình yêu nồng cháy.\n\nNgoài ra, hoa tulip, hoa lily, và hoa cẩm chướng cũng là những lựa chọn tuyệt vời. Mỗi loại hoa đều mang một thông điệp riêng, hãy chọn loại hoa phù hợp nhất để gửi gắm tình cảm của bạn.",
                'image' => 'blog/blog-2.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Ý nghĩa của màu sắc hoa',
                'content' => "Màu sắc của hoa không chỉ đẹp mắt mà còn chứa đựng nhiều ý nghĩa sâu sắc. Hoa đỏ tượng trưng cho tình yêu và đam mê, hoa trắng đại diện cho sự thuần khiết và trong sáng.\n\nHoa vàng mang ý nghĩa của niềm vui và hạnh phúc, trong khi hoa hồng biểu thị sự bí ẩn và quyến rũ. Hãy chọn màu sắc phù hợp để truyền tải thông điệp của bạn một cách hoàn hảo nhất.",
                'image' => 'blog/blog-3.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Cách giữ hoa tươi lâu hơn',
                'content' => "Để hoa tươi lâu hơn, bạn cần cắt thân hoa theo góc 45 độ trước khi cắm vào bình. Thay nước sạch mỗi ngày và thêm một chút đường hoặc thuốc giữ hoa vào nước.\n\nĐặt bình hoa ở nơi thoáng mát, tránh ánh nắng trực tiếp. Loại bỏ những lá úa và hoa héo để tránh làm hỏng những bông hoa còn lại. Với cách chăm sóc đúng cách, hoa của bạn có thể tươi đẹp lên đến 2 tuần.",
                'image' => 'blog/blog-4.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Xu hướng cắm hoa hiện đại 2025',
                'content' => "Năm 2025 chứng kiến sự trở lại của phong cách cắm hoa tự nhiên và tối giản. Xu hướng này tập trung vào việc sử dụng ít loại hoa nhưng sắp xếp một cách tinh tế và sang trọng.\n\nMàu sắc pastel và trung tính đang rất được ưa chuộng, tạo nên vẻ đẹp nhẹ nhàng và thanh lịch. Kết hợp hoa với lá xanh tự nhiên cũng là một xu hướng đang lên, mang lại cảm giác gần gũi với thiên nhiên.",
                'image' => 'blog/blog-5.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
