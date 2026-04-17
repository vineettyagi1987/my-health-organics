@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<style>
    .section-box {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .section-title1 {
        font-weight: 700;
        margin-bottom: 15px;
        border-left: 5px solid #198754;
        padding-left: 10px;
    }

    .card-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        height: 100%;
        transition: 0.3s;
    }

    .card-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    ul {
        padding-left: 18px;
    }
</style>

<div class="container my-5">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-success">🌿 Save The Nature Trust (STNT) Brochure</h1>
        <p class="text-muted">Building a Healthier Planet & Better Future</p>
    </div>

    <!-- ABOUT -->
   <section class="about-section">

  

    <p><strong>Welcome to Save The Nature Trust.</strong></p>

    <p>
       Nature is the foundation of life, and the well-being of humanity is deeply connected to the health
of our environment. In recent years, we have witnessed rapid environmental degradation,
increasing pollution, unhealthy lifestyles, and a gradual decline in cultural and human values.
These challenges demand collective awareness and responsible action.
    </p>

    <p>
       Save The Nature Trust (a non-profit organization) is established with the vision of bringing
together scientists, professionals, educators, and socially responsible individuals to work toward
protecting nature and promoting sustainable living. Our goal is not only to preserve the
environment but also to create a society that respects natural resources, values health and wellbeing,
and upholds ethical and cultural principles.
    </p>

    <p>
      Through our initiatives in environmental conservation, organic farming, renewable energy
awareness, health and wellness, and youth education, we aim to inspire communities to adopt
sustainable and responsible lifestyles.
    </p>

    <p>
       We believe that meaningful change can only occur through collaboration, awareness, and
dedicated efforts from individuals and communities. Together, we can create a healthier planet
and a better future for generations to come.
    </p>

    <p class="fw-bold text-success">
        We welcome you to join us in this mission.
    </p>

    <div class="mt-4">
        <h5 class="fw-bold">Founders</h5>
        <p>Save The Nature Trust</p>
    </div>

</section>

    <!-- VISION + MISSION -->
    <div class="row">
        <div class="col-md-6">
            <div class="section-box">
                <h4 class="section-title">🌍 Vision</h4>
                <p>
                   “Healthier Planet and Better Future”. Promoting scientific innovation, conscious and sustainable development for the benefit of human
health, build a sustainable and environmentally conscious society where people live in harmony
with nature, adopt sustainable lifestyles, and uphold strong cultural and ethical values. We aim to
create a future in which environmental protection, ethical values, and cultural heritage are
preserved.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="section-box">
                <h4 class="section-title">🎯 Mission</h4>
                <p>
                The mission of Save The Nature Trust is to protect human health, nature and restore the natural
environment while promoting sustainable lifestyles and strengthening human values. We work to
achieve this by combining scientific knowledge, environmental awareness, community
participation, and traditional wisdom.
                </p>
            </div>
        </div>
    </div>

    <!-- ADVISORY -->
  <div class="card shadow-sm p-4 mb-5">
    
    <h3 class="section-title">Advisory Board</h3>

    <p>
       The Advisory Board of Save The Nature Trust (STNT) consists of experienced professionals,
scientists, educators, and socially responsible individuals who volunteer their knowledge and
expertise to guide the Trust in achieving its mission and vision. The board provides strategic
advice, scientific and technical insight, and independent perspectives to help strengthen the
Trust’s initiatives and long-term goals. By supporting the planning and implementation of
programs related to environmental conservation, sustainable agriculture, health and wellness,
renewable energy awareness, and community education, the Advisory Board plays an important
role in ensuring that the organization’s activities remain impactful, credible, and aligned with its
core values. Through their guidance and commitment, the Advisory Board helps STNT promote
responsible stewardship of natural resources and encourages collaborative efforts toward
building a healthier, environmentally conscious, and sustainable society for future generations.
    </p>


</div>

        <div class="card-box mt-3">
            <strong>Prof. (Dr.) Pradeep Kumar Prajapati</strong><br>
            MD, PhD (Ayurveda)<br>
            (BHU)
Director, All India Institute of Ayurveda (AIIA),
New Delhi, India
Ex-Vice-Chancellor, Rajasthan Ayurved University, Jodhpur
        </div>
   

    <!-- WORK AREAS -->
    <div class="section-box">
        <h3 class="section-title text-center">Projects & Key Areas</h3>
        <p>Save The Nature Trust actively implements projects that promote environmental protection,
community development, and sustainable living.</p>
        <div class="row g-4">

        <div class="card shadow-sm p-4 mb-4">

    <h4 class="fw-bold text-success">
        🌱 Organic Food & Organic Farming
    </h4>

    <p>
       We encourage the cultivation and consumption of organic food to promote healthy lifestyles and
sustainable farming. Our organization provides training programs for farmers led by
experienced experts to support the adoption of practical organic and natural farming methods.
Our organization promotes sustainable agriculture by encouraging farmers to adopt organic
farming techniques that protect food and soil from harmful chemical pollutants to restore human
health, animal and soil health.
    </p>

    <ul class="mt-3">
        <li>Promote and produce healthier organic foods and food production systems</li>
        <li>Train farmers in practical organic and natural farming methods</li>
        <li>Improve soil quality and agricultural sustainability</li>
    </ul>

</div>

           <div class="card shadow-sm p-4 mb-4">
    <!-- same content -->
       <h4 class="fw-bold text-success">
        🌳 Environmental Protection
    </h4>

    <p>
      To promote organic/natural foods, soil, flora and fauna, and healthy lifestyle, we organize
environmental awareness campaigns, tree plantation drives, and educational workshops to
promote conservation of natural resources and ecological balance through the following-
    </p>

    <ul class="mt-3">
        <li>
            Promote and facilitate plastic-free events and celebrations 
            (birthdays, marriages, engagements, inaugurations, and other occasions)
        </li>
        <li>
            Increase public awareness about soil, animals, and environmental protection
        </li>
        <li>
            Encourage community participation in nature conservation efforts
        </li>
        <li>
            Promote sustainable environmental practices that support healthy lifestyles
        </li>
    </ul>
</div>

           <div class="card shadow-sm p-4 mb-4">
    <!-- same content -->
      <h4 class="fw-bold text-success">
        🧘 Health and Wellness
    </h4>

    <p>
       We support holistic health and disease prevention by facilitating guidance from qualified yoga
instructors and Ayurvedic practitioners. These initiatives aim to promote physical, mental,
and emotional well-being in communities.
    </p>

    <ul class="mt-3">
        <li>Promote natural healthcare practices (Ayurvedic medicines) and preventive care</li>
        <li>Promote non-toxic, aluminum-free cooking and kitchenware for better daily health</li>
        <li>Encourage non-toxic cooking practices in marriages and social events</li>
        <li>Promote eco-friendly earthenware and traditional clay pots for healthier living</li>
        <li>Produce and supply nutritional health supplements and Ayurvedic products</li>
    </ul>
</div>

 <div class="card shadow-sm p-4 h-100">

            <h5 class="fw-bold text-success">
                ☀ Renewable Energy
            </h5>

            <p>
              Our organization promotes the use of renewable energy sources such as solar power appliances
for regular use and encourages environmentally friendly technologies to reduce pollution and
pollution-free healthy life. We also facilitate and provide electric powered vehicles. Some of the
products are-
            </p>

            <ul>
                <li>Solar panels</li>
                <li>Solar lights</li>
                <li>Solar surveillance cameras</li>
                <li>Renewable energy services</li>
                <li>Electric two-wheelers / bikes</li>
            </ul>

        </div>

          <div class="card shadow-sm p-4 h-100">

            <h5 class="fw-bold text-success">
                🎓 Education Counselling & Career Development
            </h5>

            <p>
             We provide career guidance, educational counselling and mentorship for students through
monthly online sessions/meetings by experienced professors, scientists, and subject experts. Our
goal is to help young individuals build a strong academic and professional career/future.
            </p>

            <ul>
                <li>Empower youth with knowledge and skills for career development</li>
                <li>Encourage scientific thinking and responsible citizenship</li>
                <li>Support future leaders and innovators</li>
            </ul>

        </div>

          <div class="card shadow-sm p-4 h-100">

            <h5 class="fw-bold text-success">
                🪔 Cultural & Ethical Awareness
            </h5>

            <p>
              We actively promote Indian cultural values, ethics, and humanitarian principles through
educational programs, seminars, workshops, and training camps that encourage responsible
citizenship and social harmony.
            </p>

            <ul>
                <li>Strengthen cultural awareness and social responsibility</li>
                <li>Encourage ethical behavior and community engagement</li>
                <li>Promote harmony between traditions, communities, and modern development</li>
            </ul>

        </div>

        </div>
    </div>

   <div class="row g-4">

    <!-- OUR ACTIVITIES -->
    <div class="col-md-6">
        <div class="card shadow-sm p-4 h-100">
            <h5 class="fw-bold text-success">Our Activities</h5>

            <p>Save The Nature Trust regularly organizes:</p>

            <ul>
                <li>Educational workshops</li>
                <li>Environmental awareness programs</li>
                <li>Training camps and seminars</li>
                <li>Community outreach initiatives</li>
                <li>Sustainable agriculture training</li>
                <li>Youth mentorship and career guidance sessions</li>
            </ul>
        </div>
    </div>

    <!-- PARTNERSHIPS -->
    <div class="col-md-6">
        <div class="card shadow-sm p-4 h-100">
            <h5 class="fw-bold text-success">National & Global Partnerships</h5>

            <ul>
                <li>Collaborate with academic institutions and research organizations</li>
                <li>Build partnerships with NGOs and government bodies</li>
                <li>Expand awareness programs to reach larger communities</li>
            </ul>
        </div>
    </div>

</div>

<!-- SUPPORT SECTION -->
<div class="card shadow-sm p-4 mt-4">

    <h4 class="fw-bold text-center text-success mb-3">Support Our Mission</h4>

    <p class="text-center">
        Protecting nature and strengthening human values requires collective efforts. 
        Save The Nature Trust welcomes individuals, organizations, and institutions 
        who wish to contribute to this mission.
    </p>

</div>

<!-- HOW YOU CAN SUPPORT -->
<div class="row g-4 mt-2">

    <!-- VOLUNTEER -->
    <div class="col-md-4">
        <div class="card shadow-sm p-4 h-100">
            <h5 class="fw-bold">🤝 Volunteer With Us</h5>

            <p>
               Volunteers are an essential part of the mission of Save The Nature Trust. We welcome
individuals who are passionate about human and animal health, environmental protection,
community development, education, and public health awareness for our nation building.
Volunteers can participate in various activities such as:
            </p>

            <ul>
                <li>Environmental awareness campaigns</li>
                <li>Tree plantation drives</li>
                <li>Organic farming training</li>
                <li>Youth education and mentoring</li>
                <li>Community health programs</li>
            </ul>

            <p class="small text-muted">
              By volunteering with us, individuals can contribute their skills, knowledge, and enthusiasm
toward creating a positive environmental and social impact.
            </p>
        </div>
    </div>

    <!-- MEMBERSHIP -->
    <div class="col-md-4">
        <div class="card shadow-sm p-4 h-100">
            <h5 class="fw-bold">👥 Membership Opportunities</h5>

            <p>
               Save The Nature Trust offers membership opportunities for individuals who wish to actively
support our mission and for serving our members and society.
Members can contribute by:
            </p>

            <ul>
                <li>Getting benefits of our services and products</li>
                <li>Referring our services</li>
                <li>Participating in organizational initiatives</li>
                <li>Supporting environmental awareness programs</li>
                <li>Promoting sustainable practices in their communities</li>
                <li>Providing expertise in areas such as science, education, health, and technology Membership helps strengthen our network of individuals committed to protecting health, nature
and building a sustainable future and strong Bharat.
                </li>
            </ul>

           
        </div>
    </div>

    <!-- PARTNER -->
    <div class="col-md-4">
        <div class="card shadow-sm p-4 h-100">
            <h5 class="fw-bold">🤝 Partner With Us</h5>

            <p>
                Organizations and institutions can collaborate with us for sustainable 
                development programs and environmental initiatives, and for getting befits of our services and products.
            </p>

            <h6 class="mt-3">We collaborate with:</h6>
            <ul>
               Save The Nature Trust believes that addressing environmental and societal challenges requires
collaboration across institutions, communities, and countries.
We actively seek partnerships with:
<li>Universities and research institutions</li>
<li>Environmental organizations and NGOs</li>
<li>Government agencies</li>
<li>International sustainability initiatives</li>
<li>Community development organizations</li>
Through these collaborations, we aim to expand research-based environmental programs,
promote sustainable development practices, and exchange knowledge that benefits both society
and the environment.</li>

            </ul>
        </div>
    </div>

</div>

<!-- FUNDING -->
<div class="card shadow-sm p-4 mt-4">

    <h5 class="fw-bold text-success">Grant & Funding Initiatives</h5>

 <p>To support our programs and expand our impact, Save The Nature Trust seeks partnerships and
funding opportunities from organizations that share our commitment to environmental
sustainability and social development.
Funding support helps us:</p>
<ul>
<li>Conduct environmental awareness and conservation programs</li>
<li>Train farmers in sustainable and organic agricultural practices</li>
<li>Promote renewable energy awareness</li>
<li>Provide educational and career guidance for students</li>
<li>Organize community health and wellness initiatives</li>
<li>Support Organic food initiative for better health and nature</li>
</ul>
<p>
We welcome collaboration with philanthropic foundations, research institutions, and
international organizations that wish to support initiatives focused on environmental protection
and sustainable development.</p>
<p>All funding and donations received are utilized responsibly and transparently to support the
mission and objectives of the organization.
</p>
</div>

<!-- DONATE -->
<div class="card shadow-sm p-4 mt-4 text-center">
     <h4 class="fw-bold text-success mb-3">Donate</h4>
   
    <p>
        Your contributions help us organize training programs, awareness campaigns, 
        and community initiatives that support nature and society.
    </p>

</div>

<!-- SPREAD AWARENESS -->
<div class="card shadow-sm p-4 mt-4 text-center">
     
    <h4 class="fw-bold text-success mb-3">Spread Awareness</h4>
    <p>
        Support our mission by improving your lifestyle and spreading awareness about 
        environmental protection, sustainable living, and cultural values.
    </p>

</div>

    <!-- TEAM -->
  

    <div class="card shadow-sm p-4 mt-4 text-center">

        <h4 class="fw-bold text-success mb-3">Our Team</h4>

        <p>
           Save The Nature Trust is supported by a dedicated network of scientists, professionals,
educators, and social contributors who share a commitment to protect our health, environmental,
knowledge dissemination, and social development.
As part of our efforts to empower individuals and communities, STNT has established a group of
volunteer faculty members (national and international) who provide guidance in education and
career development through monthly online sessions (Dates and time will be on our website,
mostly on last Sunday of every month). These experienced mentors offer valuable insights,
experiences, academic direction, and professional advice to help members make informed
decisions about their educational and career paths.
The career guidance and education counselling services provided by these volunteer faculties are
designed exclusively for members of Save The Nature Trust. Through this initiative, STNT aims
to support personal growth, promote responsible leadership, and encourage the next generation to
contribute meaningfully toward a sustainable and environmentally conscious society.
        </p>

    </div>


    <!-- FACULTY -->
     <div class="card shadow-sm p-4 mt-4 text-center">

        <h4 class="fw-bold text-success mb-4 text-center">
            Faculties (Volunteers) for Career Guidance & Education Counselling
        </h4>

        <div class="row g-4">

            <!-- Member -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Dr. Shivendra Tenguria, Ph.D.</h6>
                    <p class="small mb-1">Research Scientist, Purdue University, USA</p>
                    <p class="small mb-1">PhD - Biotechnology, University of Hyderabad</p>
                    <p class="small text-muted">Fellowships: ICMR-JRF, CSIR-NET-JRF, GATE</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Dr. Ashutosh Kumar, Ph.D.</h6>
                    <p class="small mb-1">Asst. Professor, Tripura University</p>
                    <p class="small mb-1">PhD - Biotechnology, University of Hyderabad</p>
                    <p class="small text-muted">Visiting Scientist - Robert Koch Institute, Germany</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Dr. V. K. Chaitanya Manam</h6>
                    <p class="small mb-1">AI Research Engineer, USA</p>
                    <p class="small mb-1">MS - IIT Madras</p>
                    <p class="small text-muted">PhD - Purdue University, USA</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Dr. Sandeep Kumar Tata</h6>
                    <p class="small mb-1">Asst. Professor, Munger University</p>
                    <p class="small mb-1">M.Tech - IIT Kharagpur</p>
                    <p class="small text-muted">PhD - South Korea</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Dr. Abhay Vishwakarma</h6>
                    <p class="small mb-1">Asst. Professor, Delhi University</p>
                    <p class="small mb-1">PhD - University of Hyderabad</p>
                    <p class="small text-muted">Fellowships: CSIR-SRF, DST-SERB</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Dr. Swati Thangariyal</h6>
                    <p class="small mb-1">Scientist, ILBS</p>
                    <p class="small mb-1">PhD - ILBS, New Delhi</p>
                    <p class="small text-muted">Fellowship: ICMR</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold">Devesh Yogi</h6>
                    <p class="small mb-1">MCA - IFTM University</p>
                    <p class="small text-muted">Ex-Software Developer, CHETU India</p>
                </div>
            </div>

        </div>

    </div>

    <!-- CORE MEMBERS -->
     <div class="card shadow-sm p-4 mt-4 text-center">

        <h4 class="fw-bold text-success mb-4 text-center">
            Core Members
        </h4>

        <p class="text-muted">
           The core members of Save The Nature Trust (STNT) are a group of committed individuals who
share a common vision of protecting nature, promoting sustainable living, and strengthening
human health and environmental responsibility. Coming from diverse professional and social
backgrounds, these members contribute their knowledge, experience, and dedication to
advancing the mission of the Trust. They work collaboratively to support initiatives related to
environmental conservation, sustainable agriculture, health and wellness, community awareness,
and education. Guided by the belief that the well-being of humanity is deeply connected to the
health of our natural environment, including humans, soil, plants, animals, and ecosystems, the
core members strive to build a healthier and more sustainable future through collective action
and responsible stewardship of nature.
        </p>

        <div class="row text-center mt-3">

            <div class="col-md-3 col-6 mb-2">Mr. Radheshyam Tenguria</div>
            <div class="col-md-3 col-6 mb-2">Dr. Shivendra Tenguria</div>
            <div class="col-md-3 col-6 mb-2">Mr. Mukesh Chand</div>
            <div class="col-md-3 col-6 mb-2">Mr. Prem Pal</div>
            <div class="col-md-3 col-6 mb-2">Mr. Devesh Yogi</div>
            <div class="col-md-3 col-6 mb-2">Mr. Arvind Singh</div>
            <div class="col-md-3 col-6 mb-2">Mr. Pradeep Kumar</div>

        </div>

    </div>




    <!-- COMMITMENT -->
     <div class="card shadow-sm p-4 mt-4 text-center">
         <h4 class="fw-bold text-success mb-4 text-center">
            Our Commitment
        </h4>

       
        <p>
           Save The Nature Trust is committed to responsible use of resources to ensure that all initiatives
contribute to meaningful and sustainable impact.
        </p>
    </div>

</div>

@endsection