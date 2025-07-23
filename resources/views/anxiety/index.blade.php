@extends('template.template')

@section('pagecontent')
<div class="max-w-[80%] mx-auto px-4 py-8 mt-12">
    <!-- Full-width Hero Image -->
    <div class="relative mb-12 rounded-lg overflow-hidden shadow-lg">
        <img src="https://images.unsplash.com/photo-1593814681464-eef5af2b0628?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
             alt="Anxiety Disorder" 
             class="w-full h-64 object-cover"> <!-- Reduced from h-80 to h-64 -->
        <div class="absolute inset-0 bg-blue-900 bg-opacity-60 flex items-center justify-center">
            <h1 class="text-4xl font-bold text-white text-center px-4">Understanding Anxiety Disorders</h1>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-2">Anxiety Disorder</h1>
        <div class="flex items-center text-sm text-blue-600">
            <a href="#" class="hover:underline">HOME</a>
            <span class="mx-2">|</span>
            <span>ANXIETY DISORDER</span>
        </div>
        <div class="border-b border-blue-200 mt-4"></div>
    </div>

    <!-- Main Content Section -->
    <div class="prose max-w-none">
        <!-- Understanding Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Understanding Anxiety Disorder: Symptoms And Treatment</h2>
            <p class="text-gray-700 mb-4">
                Everyone will experience feelings of anxiety at one point or another. It is a common human emotion. Most people will have anxiety before events like a big exam, first date, or job interview. However, people with an anxiety disorder will experience intense fear, distress, and worry for no apparent reason. If left untreated, an anxiety disorder can seriously impact a person's quality of life.
            </p>
            <p class="text-gray-700 mb-4">
                Since anxiety disorders are a group of related disorders instead of one single condition, symptoms will differ for each individual. While some individuals may have uncontrollable intrusive thoughts, others may suffer from intense anxiety attacks that appear seemingly out of nowhere. Another may live in a constant state of worry over just about everything. Despite the different forms, anxiety disorders bring upon an irrational fear that is out of proportion to the "danger" at hand.
            </p>
            <p class="text-gray-700 mb-4">
                According to a recent survey of about 10,000 respondents across India, a majority has felt that their mental health has worsened. There was some age-wise difference here, as the figure varied from 25% for pre-millennials to 20% for post-millennials. Among those who felt more lonely or more worried, this figure was as high as 40%. Across age and gender groups, post-millennial women were most likely to report a deterioration in mental health.
            </p>
        </section>

        <!-- Symptoms Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-800 mb-6">Symptoms Of Anxiety</h2>
            
            <!-- Emotional Symptoms with Image Side by Side -->
            <div class="flex flex-col lg:flex-row gap-6 mb-6">
                <div class="lg:w-1/2 bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <h3 class="text-xl font-medium text-blue-800 mb-4">Common Emotional Signs and Symptoms:</h3>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Feeling apprehensive</li>
                        <li>Anticipating the worst</li>
                        <li>Excessive worrying</li>
                        <li>Feeling agitated</li>
                        <li>Feeling of panic</li>
                        <li>Unable to stay calm</li>
                        <li>Feeling like your mind has gone blank</li>
                        <li>Irritability</li>
                        <li>Trouble concentrating</li>
                        <li>Constantly watching for signs of danger</li>
                        <li>Feelings of dread</li>
                        <li>The desire to avoid triggers</li>
                    </ul>
                </div>
                
                <!-- Image beside Emotional Symptoms with reduced height -->
                <div class="lg:w-1/2 flex items-center">
                    <div class="w-full h-[30rem] rounded-lg overflow-hidden shadow-md border border-blue-100"> <!-- Added h-64 here -->
                        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" 
                             alt="Emotional anxiety symptoms" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            
            <!-- Physical Symptoms (Full Width) -->
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                <h3 class="text-xl font-medium text-blue-800 mb-4">Common Physical Signs and Symptoms:</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li>Rapid heart rate</li>
                    <li>Sweating</li>
                    <li>Stomach issues</li>
                    <li>Dry mouth</li>
                    <li>Muscle tension</li>
                    <li>Cold, numb, or tingling hands/feet</li>
                    <li>Dizziness</li>
                    <li>Hyperventilation</li>
                    <li>Nausea</li>
                    <li>Insomnia</li>
                    <li>Headaches</li>
                </ul>
            </div>
            
            <p class="text-gray-700 mt-6">
                Luckily, anxiety disorders are highly treatable. Understanding the different anxiety disorders is crucial in taking the steps necessary towards getting treatment and regaining control of your life.
            </p>
        </section>

        <!-- Rest of the content remains exactly the same -->
        <!-- Types Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Types Of Anxiety Disorders</h2>
            <p class="text-gray-700 mb-4">There are several types of anxiety disorders, including:</p>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <h3 class="text-xl font-medium text-blue-800 mb-2">Generalized Anxiety Disorder</h3>
                    <p class="text-gray-700">
                        Characterized by excessive worry about everyday life events with no obvious reason to worry. People with GAD tend to always expect the worst possible outcome, with worry out of proportion to the actual situation.
                    </p>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <h3 class="text-xl font-medium text-blue-800 mb-2">Panic Disorder</h3>
                    <p class="text-gray-700">
                        Involves recurrent panic attacks—sudden periods of intense fear that may include palpitations, pounding heart, or accelerated heart rate. These attacks often occur unexpectedly.
                    </p>
                </div>
            </div>
        </section>

        <!-- Treatment Section -->
        <section class="mb-12 bg-blue-100 p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-semibold text-blue-800 mb-6">Treatment Options</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-medium text-blue-800 mb-3">Professional Treatments</h3>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li><strong>Cognitive Behavioral Therapy (CBT):</strong> Identify and change negative thought patterns</li>
                        <li><strong>Medication:</strong> SSRIs, SNRIs, or benzodiazepines may be prescribed</li>
                        <li><strong>Exposure Therapy:</strong> Gradually facing feared situations</li>
                        <li><strong>Mindfulness-Based Therapies:</strong> Meditation and relaxation techniques</li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-medium text-blue-800 mb-3">Self-Help Strategies</h3>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Regular exercise and physical activity</li>
                        <li>Maintaining a healthy sleep schedule</li>
                        <li>Limiting caffeine and alcohol intake</li>
                        <li>Practicing relaxation techniques</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Prevention Section -->
        <section class="mb-12 bg-blue-50 p-8 rounded-lg border border-blue-200">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Prevention Strategies</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-medium text-blue-800 mb-3">Lifestyle Approaches</h3>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Maintain a balanced, nutritious diet</li>
                        <li>Establish a regular sleep routine</li>
                        <li>Engage in regular physical activity</li>
                        <li>Practice stress-reduction techniques</li>
                        <li>Build a strong social support network</li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-medium text-blue-800 mb-3">Early Intervention</h3>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Recognize early warning signs</li>
                        <li>Seek help at first symptoms</li>
                        <li>Develop healthy coping mechanisms</li>
                        <li>Consider therapy even for mild anxiety</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Substance Abuse Section -->
        <section class="mb-12 bg-blue-100 p-8 rounded-lg shadow-sm">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Substance Abuse and Anxiety</h2>
            <p class="text-gray-700 mb-4">
                About 20% of individuals with anxiety disorders also have substance use disorders. People with anxiety may attempt to lessen symptoms using drugs or alcohol, which typically exacerbates anxiety symptoms.
            </p>
            
            <div class="bg-blue-800 text-white p-6 rounded-lg">
                <h3 class="text-xl font-medium mb-3">Integrated Treatment Approach</h3>
                <p class="mb-4">
                    Effective treatment addresses both substance abuse and the underlying anxiety disorder simultaneously through approaches like:
                </p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Cognitive Behavioral Therapy</li>
                    <li>Relaxation Training</li>
                    <li>Breathwork Therapy</li>
                    <li>Medication management</li>
                </ul>
            </div>
        </section>
    </div>
</div>
@endsection