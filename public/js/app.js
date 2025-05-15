// Initialize AOS animation library with more options
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced AOS initialization
    AOS.init({
        duration: 800,
        once: false,       // Allow animations to trigger again
        easing: 'ease-in-out-quad',
        mirror: true,      // Animate elements when scrolling back up
        offset: 120        // Trigger animations 120px before element
    });

    // Enhanced smooth scrolling with offset for fixed header
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerHeight = document.querySelector('nav').offsetHeight;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Active nav link indicator with smooth highlight transition
    const sections = document.querySelectorAll('section');
    const navItems = document.querySelectorAll('.nav-link');
    
    window.addEventListener('scroll', function() {
        let current = '';
        const scrollPosition = window.pageYOffset + 200; // 200px offset
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${current}`) {
                item.classList.add('active');
                // Add pulse animation to highlight
                item.style.animation = 'pulse 0.5s ease';
                setTimeout(() => {
                    item.style.animation = '';
                }, 500);
            }
        });
    });

    // Enhanced promo slider with fade animations
    const promos = [
        {
            title: "Diskon 30%",
            description: "Untuk semua menu nasi goreng setiap hari Senin",
            code: "NASGOR30",
            bgColor: "#FF6B6B"
        },
        {
            title: "Gratis Ongkir",
            description: "Minimal pembelian Rp 50.000",
            code: "GRATISONGKIR",
            bgColor: "#4ECDC4"
        },
        {
            title: "Paket Hemat",
            description: "Nasi Goreng + Es Teh hanya Rp 25.000",
            code: "HEMAT25",
            bgColor: "#45B7D1"
        }
    ];

    const promoSlider = document.querySelector('.promo-section');
    if (promoSlider) {
        let currentPromo = 0;
        
        function showPromo(index) {
            // Animate background color transition
            promoSlider.style.transition = 'background 1s ease';
            promoSlider.style.background = `linear-gradient(135deg, ${promos[index].bgColor}, ${darkenColor(promos[index].bgColor, 20)})`;
            
            // Create promo content with animation classes
            const promoContent = `
                <div class="promo-item text-center p-4" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="mb-3">${promos[index].title}</h3>
                    <p class="mb-4">${promos[index].description}</p>
                    <div class="promo-code bg-white text-dark d-inline-block px-3 py-2 rounded" data-aos="zoom-in" data-aos-delay="500">
                        Gunakan kode: <strong>${promos[index].code}</strong>
                    </div>
                </div>
            `;
            
            // Add fade out/in transition
            const sliderElement = document.querySelector('.promo-slider');
            sliderElement.style.opacity = 0;
            setTimeout(() => {
                sliderElement.innerHTML = promoContent;
                sliderElement.style.opacity = 1;
                sliderElement.style.transition = 'opacity 0.5s ease';
                
                // Refresh AOS for new elements
                AOS.refresh();
            }, 500);
        }
        
        // Helper function to darken colors
        function darkenColor(color, percent) {
            const num = parseInt(color.replace("#", ""), 16);
            const amt = Math.round(2.55 * percent);
            const R = (num >> 16) - amt;
            const G = (num >> 8 & 0x00FF) - amt;
            const B = (num & 0x0000FF) - amt;
            return `#${(
                0x1000000 +
                (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 +
                (G < 255 ? (G < 1 ? 0 : G) : 255) * 0x100 +
                (B < 255 ? (B < 1 ? 0 : B) : 255)
            ).toString(16).slice(1)}`;
        }
        
        showPromo(0);
        
        // Auto rotate promos every 5 seconds with animation
        setInterval(() => {
            currentPromo = (currentPromo + 1) % promos.length;
            showPromo(currentPromo);
        }, 5000);
    }

    // Enhanced testimonial slider with staggered animations
    const testimonials = [
        {
            name: "Budi Santoso",
            role: "Pelanggan Setia",
            comment: "Makanannya enak dan harganya terjangkau. Pengiriman juga cepat!",
            rating: 5,
            avatar: "avatar.jpeg"
        },
        {
            name: "Ani Wijaya",
            role: "Mahasiswa",
            comment: "Tempat langganan saya sejak pindah kos. Menu lengkap dan rasanya konsisten.",
            rating: 4,
            avatar: "avatar2.jpeg"
        },
        {
            name: "Dewi Lestari",
            role: "Karyawan",
            comment: "Suka dengan pelayanannya ramah. Menu sehatnya recommended banget!",
            rating: 5,
            avatar: "avatar3.jpeg"
        }
    ];

    const testimonialSlider = document.querySelector('.testimonial-slider');
    if (testimonialSlider) {
        let currentTestimonial = 0;
        
        function showTestimonial(index) {
            let stars = '';
            for (let i = 0; i < testimonials[index].rating; i++) {
                stars += `<i class="fas fa-star text-warning" data-aos="fade-up" data-aos-delay="${i * 100}"></i>`;
            }
            
            const testimonialHTML = `
                <div class="testimonial-item bg-white p-4 rounded shadow text-center mx-auto" style="max-width: 600px;">
                    <div class="avatar mb-3" data-aos="zoom-in">
                        <img src="images/${testimonials[index].avatar}" alt="${testimonials[index].name}" class="rounded-circle" width="80">
                    </div>
                    <div class="mb-3" data-aos="fade-up">${stars}</div>
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="200">"${testimonials[index].comment}"</p>
                    <h5 class="mb-1" data-aos="fade-up" data-aos-delay="300">${testimonials[index].name}</h5>
                    <small class="text-muted" data-aos="fade-up" data-aos-delay="400">${testimonials[index].role}</small>
                </div>
            `;
            
            // Add fade transition
            testimonialSlider.style.opacity = 0;
            testimonialSlider.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                testimonialSlider.innerHTML = testimonialHTML;
                testimonialSlider.style.opacity = 1;
                
                // Refresh AOS for new elements
                AOS.refresh();
            }, 500);
        }
        
        showTestimonial(0);
        
        // Auto rotate testimonials every 7 seconds with animation
        setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }, 7000);
    }

    // Additional animations for menu cards on hover
    const menuCards = document.querySelectorAll('.menu-card');
    menuCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px)';
            card.style.boxShadow = '0 15px 30px rgba(0,0,0,0.2)';
            card.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
            card.style.boxShadow = '';
        });
    });

    // Animate elements when they come into view
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[data-aos]');
        elements.forEach(el => {
            const elPosition = el.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elPosition < windowHeight - 100) {
                el.classList.add('aos-animate');
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on load
});

// Add CSS for pulse animation
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .nav-link.active {
        color: #4CAF50 !important;
        font-weight: bold;
        position: relative;
    }
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: #4CAF50;
        border-radius: 3px;
        animation: grow 0.3s ease;
    }
    @keyframes grow {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }
`;
document.head.appendChild(style);

// Contact form handling
// Contact form handling
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const spinner = document.getElementById('spinner');
            const formMessage = document.getElementById('formMessage');
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.textContent = 'Mengirim...';
            spinner.classList.remove('d-none');
            formMessage.textContent = '';
            formMessage.className = 'mt-3';
            
            try {
                const formData = new FormData(contactForm);
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (!response.ok) throw new Error(data.message || 'Failed to send message');
                
                // Show success message
                formMessage.textContent = data.message || 'Thank you for your message!';
                formMessage.classList.add('alert', 'alert-success');
                
                // Reset form
                contactForm.reset();
                
            } catch (error) {
                // Show error message
                formMessage.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi nanti.';
                formMessage.classList.add('alert', 'alert-danger');
                console.error('Error:', error);
                
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Send Message';
                spinner.classList.add('d-none');
                
                // Scroll to message
                formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    }
});