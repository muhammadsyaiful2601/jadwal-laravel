/**
         * Real-time Clock updater
         * Updates the header clock and info box time every second
         */
        function startRealtimeClock() {
            function updateClock() {
                const now = new Date();

                // Format time HH:MM:SS
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeStr = hours + ':' + minutes + ':' + seconds;
                const timeStrShort = hours + ':' + minutes;

                // Format date in Indonesian
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ];
                const dayName = days[now.getDay()];
                const date = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const dateStr = dayName + ', ' + date + ' ' + month + ' ' + year;

                // Update header clock
                const headerTime = document.getElementById('headerClockTime');
                const headerDate = document.getElementById('headerClockDate');
                if (headerTime) headerTime.textContent = timeStr;
                if (headerDate) headerDate.textContent = dateStr;

                // Update info box time
                const infoBoxTime = document.getElementById('liveTimeInfoBox');
                if (infoBoxTime) infoBoxTime.textContent = timeStr;
            }

            updateClock();
            realtimeClockInterval = setInterval(updateClock, 1000);
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
        }

        function applyFilter(button) {
            const type = button.dataset.type;
            const value = button.dataset.value;
            const params = new URLSearchParams(window.location.search);

            // Update active state
            const container = button.parentElement;
            container.querySelectorAll('.filter-pill').forEach(pill => pill.classList.remove('active'));
            button.classList.add('active');

            if (type === 'hari') {
                // Specific day selected
                params.delete('semua_hari');
                params.set('hari', value);
                // Keep kelas if exists, otherwise add default first class
                if (!params.has('kelas') || params.get('kelas') === '1') {
                    params.set('kelas', firstClass);
                }
                params.delete('semua_kelas');
            } else if (type === 'semua_hari') {
                // All days selected
                params.set('semua_hari', '1');
                params.delete('hari');
                // Keep kelas if exists, otherwise use first class
                if (!params.has('kelas')) {
                    params.set('kelas', firstClass);
                }
            } else if (type === 'kelas') {
                // Specific class selected
                params.delete('semua_kelas');
                params.set('kelas', value);
                // Keep hari if exists, otherwise use current day
                if (!params.has('hari') || params.get('hari') === '1') {
                    params.set('hari', currentDay);
                }
                params.delete('semua_hari');
            } else if (type === 'semua_kelas') {
                // All classes selected
                params.set('semua_kelas', '1');
                params.delete('kelas');
                // Keep hari if exists, otherwise use current day
                if (!params.has('hari')) {
                    params.set('hari', currentDay);
                }
            }

            window.location.href = '?' + params.toString();
        }

        function handleShowAllSchedule() {
            window.location.href = '?semua_hari=1&semua_kelas=1';
        }

        function handleResetFilter() {
            const hariSekarang = currentDay > 5 ? 1 : currentDay;
            const kelasPertama = firstClass;
            window.location.href = '?hari=' + hariSekarang + '&kelas=' + encodeURIComponent(kelasPertama);
        }

        function toggleCurrentSchedule() {
            const section = document.getElementById('currentNextSection');
            const toggleIcon = document.getElementById('toggleIcon');
            if (section && toggleIcon) {
                section.classList.toggle('collapsed-section');
                if (section.classList.contains('collapsed-section')) {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                    try {
                        localStorage.setItem('scheduleVisible', 'false');
                    } catch (e) {}
                } else {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                    try {
                        localStorage.setItem('scheduleVisible', 'true');
                    } catch (e) {}
                }
            }
        }

        function refreshCurrentSchedule(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            window.location.reload();
        }

        // Show room photo popup
        function showRoomPhoto(roomName) {
            const modal = document.getElementById('roomPhotoModal');
            const photoContainer = document.getElementById('roomPhotoContainer');

            if (ruanganMap && ruanganMap[roomName]) {
                const photoFilename = ruanganMap[roomName];
                const photoUrl = window.ROOMS_ASSET_URL + '/' + photoFilename;
                const img = document.createElement('img');
                img.src = photoUrl;
                img.alt = "Foto Ruangan " + roomName;
                img.className = "img-fluid";
                img.style.maxHeight = "500px";
                img.style.objectFit = "contain";
                img.onerror = function() {
                    photoContainer.innerHTML = `
                        <div class="room-photo-placeholder" style="padding: 60px 20px; color: var(--nb-dark);">
                            <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px;"></i>
                            <p class="mb-0">Foto tidak tersedia</p>
                        </div>
                    `;
                };
                photoContainer.innerHTML = '';
                photoContainer.appendChild(img);
            } else {
                photoContainer.innerHTML = `
                    <div class="room-photo-placeholder" style="padding: 60px 20px; color: var(--nb-dark);">
                        <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px;"></i>
                        <p class="mb-0">Foto tidak tersedia</p>
                    </div>
                `;
            }

            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        }

        // Detail modal
        function showScheduleDetail(data) {
            const modal = document.getElementById('scheduleModal');
            const detail = document.getElementById('scheduleDetail');
            const bootstrapModal = new bootstrap.Modal(modal);

            // Check if room photo exists
            let roomPhotoHTML = '';
            if (ruanganMap && ruanganMap[data.ruang]) {
                const photoFilename = ruanganMap[data.ruang];
                const photoUrl = window.ROOMS_ASSET_URL + '/' + photoFilename;
                roomPhotoHTML = `
                    <div class="col-md-6">
                        <div class="room-photo-detail" style="background: var(--nb-white); border: var(--nb-border); border-radius: var(--nb-radius); overflow: hidden; box-shadow: var(--nb-shadow-sm);">
                            <img src="${photoUrl}" alt="Foto Ruangan ${data.ruang}" style="width: 100%; height: 250px; object-fit: cover; display: block;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="room-photo-fallback" style="display: none; padding: 40px 20px; text-align: center; background: var(--nb-offwhite); color: var(--nb-dark); flex-direction: column; align-items: center; justify-content: center; min-height: 250px;">
                                <i class="fas fa-image d-block" style="font-size: 3rem; margin-bottom: 12px; color: var(--nb-dark);"></i>
                                <p class="mb-0" style="font-weight: 600;">Foto tidak tersedia</p>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <small style="font-weight: 600; color: var(--nb-dark);"><i class="fas fa-door-open me-1"></i> Ruang ${data.ruang}</small>
                        </div>
                    </div>
                `;
            } else {
                roomPhotoHTML = `
                    <div class="col-md-6">
                        <div class="room-photo-detail" style="background: var(--nb-offwhite); border: var(--nb-border); border-radius: var(--nb-radius); padding: 40px 20px; text-align: center; min-height: 250px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: var(--nb-shadow-sm);">
                            <i class="fas fa-image d-block" style="font-size: 3rem; margin-bottom: 12px; color: var(--nb-dark);"></i>
                            <p class="mb-0" style="font-weight: 600; color: var(--nb-dark);">Foto Ruangan Tidak Tersedia</p>
                            <small style="color: var(--nb-dark);">Ruang ${data.ruang}</small>
                        </div>
                    </div>
                `;
            }

            detail.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3" style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1.5rem;">${data.mata_kuliah}</h4>
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 140px;"><i class="fas fa-clock me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Waktu</td>
                                <td><strong>${data.waktu}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-list-ol me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Jam ke-</td>
                                <td><strong>${data.jam_ke}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-user-tie me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Dosen</td>
                                <td><strong>${data.dosen}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-door-open me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Ruang</td>
                                <td><strong>${data.ruang}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-users me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Kelas</td>
                                <td><strong>${data.kelas}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-day me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Hari</td>
                                <td><strong>${data.hari}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Semester</td>
                                <td><strong>${data.semester} ${data.tahun_akademik}</strong></td>
                            </tr>
                        </table>
                    </div>
                    ${roomPhotoHTML}
                    <div class="col-md-6">
                        <div class="card" style="background: var(--nb-yellow); border: var(--nb-border); border-radius: var(--nb-radius); box-shadow: var(--nb-shadow-sm);">
                            <div class="card-body text-center py-5">
                                <div class="display-1 fw-bold mb-3" style="font-family: 'Space Grotesk', sans-serif; color: var(--nb-black); font-size: 4rem; font-weight: 900; text-shadow: 3px 3px 0 rgba(0,0,0,0.1);">${data.jam_ke}</div>
                                <h6 style="font-weight: 600;">Jam ke-${data.jam_ke}</h6>
                                <span class="badge-pill success-pill mt-2" style="font-size: 0.875rem; background: var(--nb-black); color: var(--nb-white);">
                                    <i class="fas fa-clock"></i> ${data.waktu}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            bootstrapModal.show();
        }

        // =============================================
        // =============================================
        // TIME-BASED GREETING
        // =============================================
        function initGreeting() {
            const emojiEl = document.getElementById('greetingEmoji');
            const textEl = document.getElementById('greetingText');
            if (!emojiEl || !textEl) return;

            function updateGreeting() {
                const hour = new Date().getHours();
                let emoji, text;

                if (hour >= 3 && hour < 6) {
                    emoji = 'ðŸŒ…';
                    text = 'Selamat subuh';
                } else if (hour >= 6 && hour < 10) {
                    emoji = 'â˜€ï¸';
                    text = 'Selamat pagi';
                } else if (hour >= 10 && hour < 12) {
                    emoji = 'ðŸŒ¤ï¸';
                    text = 'Selamat siang';
                } else if (hour >= 12 && hour < 15) {
                    emoji = 'ðŸŒž';
                    text = 'Selamat siang';
                } else if (hour >= 15 && hour < 18) {
                    emoji = 'ðŸŒ…';
                    text = 'Selamat sore';
                } else if (hour >= 18 && hour < 21) {
                    emoji = 'ðŸŒ†';
                    text = 'Selamat petang';
                } else {
                    emoji = 'ðŸŒ™';
                    text = 'Selamat malam';
                }

                emojiEl.textContent = emoji;
                textEl.textContent = text;
            }

            updateGreeting();
            setInterval(updateGreeting, 60000); // Check every minute
        }

        // =============================================
        // RIPPLE EFFECT ON CLICK
        // =============================================
        function initRippleEffect() {
            document.querySelectorAll('.schedule-list-card, .btn-detail-modern, .btn-filter-action').forEach(function(el) {
                el.classList.add('ripple-container');
                el.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.className = 'ripple-effect';
                    ripple.style.width = size + 'px';
                    ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    this.appendChild(ripple);
                    setTimeout(function() {
                        ripple.remove();
                    }, 600);
                });
            });
        }

        // =============================================
        // ANIMATED COUNTER
        // =============================================
        function initAnimatedCounter() {
            const countEl = document.getElementById('scheduleCount');
            if (!countEl) return;

            const target = parseInt(countEl.textContent) || 0;

            function animateCount() {
                countEl.classList.add('count-pop');
                setTimeout(function() {
                    countEl.classList.remove('count-pop');
                }, 400);
            }

            // Pop on load
            setTimeout(animateCount, 300);

            // Re-pop on scroll reveal
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateCount();
                    }
                });
            });
            observer.observe(countEl);
        }

        // =============================================
        // CARD 3D STACK ENTRANCE (Enhanced)
        // =============================================
        function initCardEntrance() {
            const cards = document.querySelectorAll('.schedule-list-card');
            cards.forEach(function(card, index) {
                // Only apply if card is not already visible via other animations
                if (!card.classList.contains('active')) {
                    card.style.opacity = '0';
                    card.classList.add('entrance');
                    card.style.animationDelay = (0.05 * index) + 's';
                    card.style.animationDuration = '0.8s';
                    card.style.animationFillMode = 'forwards';
                }
            });
        }

        // =============================================
        // STAMP BADGES FOR EMPTY STATE
        // =============================================
        function initStampBadges() {
            // Add stamp badges to empty state if needed
            const emptyCards = document.querySelectorAll('.schedule-card-body.flex-center');
            emptyCards.forEach(function(card) {
                if (!card.querySelector('.stamp-badge')) {
                    const header = card.closest('.schedule-card')?.querySelector('.schedule-card-header');
                    if (header) {
                        const stamps = document.createElement('div');
                        stamps.style.cssText = 'display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px;';
                        stamps.innerHTML = `
                            <span class="stamp-badge"><i class="fas fa-check"></i> LIBUR</span>
                            <span class="stamp-badge"><i class="fas fa-clock"></i> ISTIRAHAT</span>
                        `;
                        header.appendChild(stamps);
                    }
                }
            });
        }

        // =============================================
        // INTERACTIVE PARTICLES BACKGROUND
        // =============================================
        function initParticles() {
            const canvas = document.getElementById('particles-canvas');
            if (!canvas) return;

            const shapes = ['circle', 'square', 'triangle'];
            const colors = ['#A66CFF', '#4ECDC4', '#FFE66D', '#FF6B6B', '#F38181', '#95E1D3', '#FFB347', '#6BB5FF'];
            const particles = [];
            const particleCount = 35;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                const shape = shapes[Math.floor(Math.random() * shapes.length)];
                const size = Math.floor(Math.random() * 16) + 6;
                const color = colors[Math.floor(Math.random() * colors.length)];

                particle.classList.add('particle', 'shape-' + shape);
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';

                if (shape === 'triangle') {
                    particle.style.borderLeftWidth = (size / 2) + 'px';
                    particle.style.borderRightWidth = (size / 2) + 'px';
                    particle.style.borderBottomWidth = size + 'px';
                    particle.style.borderBottomColor = color;
                } else {
                    particle.style.background = color;
                    if (shape === 'square') {
                        particle.style.borderRadius = '2px';
                        particle.style.transform = 'rotate(' + Math.floor(Math.random() * 90) + 'deg)';
                    }
                }

                const startX = Math.random() * window.innerWidth;
                const startY = Math.random() * window.innerHeight;

                particle.style.left = startX + 'px';
                particle.style.top = startY + 'px';

                canvas.appendChild(particle);

                particles.push({
                    el: particle,
                    x: startX,
                    y: startY,
                    size: size,
                    speedX: (Math.random() - 0.5) * 0.5,
                    speedY: (Math.random() - 0.5) * 0.5,
                    rotation: Math.random() * 360,
                    rotSpeed: (Math.random() - 0.5) * 1,
                    visible: false,
                    delay: Math.random() * 3000
                });
            }

            // Animate
            function animateParticles() {
                const now = Date.now();

                particles.forEach(function(p) {
                    // Show with delay
                    if (!p.visible && now > p.delay) {
                        p.visible = true;
                        p.el.classList.add('visible');
                    }

                    if (!p.visible) return;

                    // Move
                    p.x += p.speedX;
                    p.y += p.speedY;
                    p.rotation += p.rotSpeed;

                    // Wrap around
                    if (p.x < -50) p.x = window.innerWidth + 50;
                    if (p.x > window.innerWidth + 50) p.x = -50;
                    if (p.y < -50) p.y = window.innerHeight + 50;
                    if (p.y > window.innerHeight + 50) p.y = -50;

                    p.el.style.left = p.x + 'px';
                    p.el.style.top = p.y + 'px';

                    if (p.el.style.transform) {
                        p.el.style.transform = 'rotate(' + p.rotation + 'deg)';
                    }
                });

                requestAnimationFrame(animateParticles);
            }

            animateParticles();

            // Resize handler
            window.addEventListener('resize', function() {
                particles.forEach(function(p) {
                    if (p.x > window.innerWidth) p.x = window.innerWidth * 0.8;
                    if (p.y > window.innerHeight) p.y = window.innerHeight * 0.8;
                });
            });
        }

        // =============================================
        // SCROLL REVEAL ANIMATIONS
        // =============================================
        function initScrollReveal() {
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

            function checkReveal() {
                const windowHeight = window.innerHeight;
                const revealPoint = 100;

                revealElements.forEach(function(el) {
                    const revealTop = el.getBoundingClientRect().top;
                    if (revealTop < windowHeight - revealPoint) {
                        el.classList.add('visible');
                    }
                });
            }

            // Check on load
            checkReveal();

            // Check on scroll with throttling
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        checkReveal();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            // Check on resize
            window.addEventListener('resize', checkReveal);
        }

        // =============================================
        // CLASS PROGRESS BAR (Current Schedule)
        // =============================================
        function initClassProgress() {
            const container = document.getElementById('classProgressContainer');
            if (!container) return;

            // Get start & end time from the schedule
            const scheduleDataEl = document.querySelector('.schedule-card.accent-green .btn-detail-modern');
            if (!scheduleDataEl) return;

            try {
                const data = JSON.parse(scheduleDataEl.dataset.schedule);
                const waktu = data.waktu || '';
                const parts = waktu.split(' - ');
                if (parts.length < 2) return;

                const startTime = parts[0].trim();
                const endTime = parts[1].trim();

                function updateProgress() {
                    const now = new Date();
                    const currentMinutes = now.getHours() * 60 + now.getMinutes();

                    const startParts = startTime.split(':');
                    const endParts = endTime.split(':');
                    const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
                    const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);

                    if (currentMinutes < startMinutes) {
                        // Class hasn't started yet
                        setProgress(0, '0%');
                        return;
                    }

                    if (currentMinutes > endMinutes) {
                        // Class has ended
                        setProgress(100, '100%');
                        return;
                    }

                    const totalDuration = endMinutes - startMinutes;
                    const elapsed = currentMinutes - startMinutes;
                    const percent = Math.min(100, Math.round((elapsed / totalDuration) * 100));

                    setProgress(percent, percent + '%');
                }

                function setProgress(percent, text) {
                    const fill = document.getElementById('classProgressFill');
                    const label = document.getElementById('classProgressPercent');
                    if (fill) fill.style.width = percent + '%';
                    if (label) label.textContent = text;
                }

                updateProgress();
                setInterval(updateProgress, 10000); // Update every 10 seconds
            } catch (e) {
                console.warn('Could not initialize class progress:', e);
            }
        }

        // =============================================
        // RANDOM COLOR ACCENT ON CARD HOVER
        // =============================================
        function initColorAccents() {
            const cards = document.querySelectorAll('.schedule-list-card');
            const accentClasses = [
                'color-accent-purple',
                'color-accent-teal',
                'color-accent-pink',
                'color-accent-orange',
                'color-accent-green',
                'color-accent-blue'
            ];

            cards.forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    // Remove any existing accent
                    accentClasses.forEach(function(cls) {
                        card.classList.remove(cls);
                    });
                    // Add random accent
                    const randomClass = accentClasses[Math.floor(Math.random() * accentClasses.length)];
                    card.classList.add(randomClass);
                });

                card.addEventListener('mouseleave', function() {
                    // Keep the accent for a moment then remove
                    var self = this;
                    setTimeout(function() {
                        accentClasses.forEach(function(cls) {
                            self.classList.remove(cls);
                        });
                    }, 500);
                });
            });
        }

        // =============================================
        // 3D TILT EFFECT - Vanilla JS
        // =============================================
        function initTiltEffect() {
            const tiltElements = document.querySelectorAll('.tilt-3d');

            tiltElements.forEach(el => {
                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * -8;
                    const rotateY = ((x - centerX) / centerX) * 8;

                    el.style.setProperty('--rotate-x', rotateX + 'deg');
                    el.style.setProperty('--rotate-y', rotateY + 'deg');

                    el.style.transform =
                        `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
                });

                el.addEventListener('mouseleave', () => {
                    el.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
                });
            });
        }

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize 3D tilt
            initTiltEffect();

            // Detail buttons
            document.querySelectorAll('.btn-detail-modern').forEach(btn => {
                btn.addEventListener('click', function() {
                    try {
                        const data = JSON.parse(this.dataset.schedule);
                        showScheduleDetail(data);
                    } catch (e) {
                        console.error('Error parsing schedule data', e);
                    }
                });
            });

            // Tooltip init
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Schedule visibility
            const scheduleVisible = localStorage.getItem('scheduleVisible');
            if (scheduleVisible === 'false') {
                const section = document.getElementById('currentNextSection');
                const toggleIcon = document.getElementById('toggleIcon');
                if (section && toggleIcon) {
                    section.classList.add('collapsed-section');
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }

            // Start real-time clock
            startRealtimeClock();

            // Initialize interactive features
            initGreeting();
            initParticles();
            initScrollReveal();
            initClassProgress();
            initColorAccents();
            initRippleEffect();
            initAnimatedCounter();
            initCardEntrance();
            initStampBadges();

            // Countdown timers for upcoming courses
            if (typeof jadwalMendatang !== 'undefined' && jadwalMendatang.length > 0) {
                startMultipleCountdownTimers();
            }

            // Suggestion form handler
            $('#suggestionForm').on('submit', function(e) {
                e.preventDefault();
                const submitBtn = $('#submitSuggestionBtn');
                const name = $('#suggestionName').val().trim();
                const message = $('#suggestionMessage').val().trim();

                if (name.length < 2) {
                    alert('Nama minimal 2 karakter');
                    $('#suggestionName').focus();
                    return;
                }
                if (message.length < 10) {
                    alert('Pesan minimal 10 karakter');
                    $('#suggestionMessage').focus();
                    return;
                }

                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...');

                const form = $(this);
                const csrfToken = form.find('input[name="_token"]').val();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#suggestionModal').modal('hide');
                            $('#suggestionForm')[0].reset();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errMsg = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                        try {
                            const resp = JSON.parse(xhr.responseText);
                            if (resp.message) errMsg = resp.message;
                        } catch (e) {}
                        alert(errMsg);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fas fa-paper-plane me-2"></i> Kirim');
                    }
                });
            });

            // Suggestion message validation
            $('#suggestionMessage').on('input', function() {
                const message = $(this).val();
                const minLength = 10;
                if (message.length < minLength && message.length > 0) {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                } else if (message.length >= minLength) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-invalid is-valid');
                }
            });

            $('#suggestionModal').on('hidden.bs.modal', function() {
                $('#suggestionForm')[0].reset();
                $('#suggestionMessage').removeClass('is-invalid is-valid');
            });
        });

        // Multiple countdown timers for upcoming courses
        window.startMultipleCountdownTimers = function() {
            if (!jadwalMendatang || jadwalMendatang.length === 0) return;

            const intervals = [];

            jadwalMendatang.forEach(function(item, index) {
                if (!item.waktu_tunggu_detik || item.waktu_tunggu_detik <= 0) return;

                let remainingSeconds = item.waktu_tunggu_detik;

                function updateCountdown() {
                    if (remainingSeconds <= 0) {
                        window.location.reload();
                        return;
                    }
                    const days = Math.floor(remainingSeconds / (24 * 3600));
                    const hours = Math.floor((remainingSeconds % (24 * 3600)) / 3600);
                    const minutes = Math.floor((remainingSeconds % 3600) / 60);
                    const seconds = remainingSeconds % 60;

                    const daysEl = document.getElementById('countdownDays' + index);
                    const hoursEl = document.getElementById('countdownHours' + index);
                    const minutesEl = document.getElementById('countdownMinutes' + index);
                    const secondsEl = document.getElementById('countdownSeconds' + index);

                    if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                    if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                    if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                    if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
                    remainingSeconds--;
                }

                updateCountdown();
                const interval = setInterval(updateCountdown, 1000);
                intervals.push(interval);
            });

            // Store intervals for cleanup
            countdownInterval = {
                clear: function() {
                    intervals.forEach(function(interval) {
                        clearInterval(interval);
                    });
                }
            };
        };

        window.startCountdownTimer = function() {
            if (!waktuTungguDetik || waktuTungguDetik <= 0) return;
            let remainingSeconds = waktuTungguDetik;

            function updateCountdown() {
                if (remainingSeconds <= 0) {
                    window.location.reload();
                    return;
                }
                const days = Math.floor(remainingSeconds / (24 * 3600));
                const hours = Math.floor((remainingSeconds % (24 * 3600)) / 3600);
                const minutes = Math.floor((remainingSeconds % 3600) / 60);
                const seconds = remainingSeconds % 60;

                const daysEl = document.getElementById('countdownDays');
                const hoursEl = document.getElementById('countdownHours');
                const minutesEl = document.getElementById('countdownMinutes');
                const secondsEl = document.getElementById('countdownSeconds');

                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
                remainingSeconds--;
            }

            updateCountdown();
            countdownInterval = setInterval(updateCountdown, 1000);
        };

        window.addEventListener('beforeunload', function() {
            if (countdownInterval) clearInterval(countdownInterval);
            if (realtimeClockInterval) clearInterval(realtimeClockInterval);
        });
    </script>
