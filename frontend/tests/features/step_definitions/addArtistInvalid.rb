And /^a word cloud is generated$/ do
    find('#vis').text.should eq ''
end

And /^I do not input an artist$/ do
    fill_in 'automplete-1', :with => ' '
end

Then /^I see no difference$/ do
    find('#vis').text.should eq ''
end

And /^the (.*) is disabled$/ do |button|
    find_button(button)[:disabled].should eq 'disabled'
end
